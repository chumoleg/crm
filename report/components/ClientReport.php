<?php

namespace report\components;

use Yii;

class ClientReport
{
    public function getData()
    {
        $sql
            = '
            SELECT 
                c.name companyName,
                COUNT(o.id) countAll,
                COUNT(IF(s.alias = "close", o.id, NULL)) countClosed,
                COUNT(IF(s.alias = "rejected", o.id, NULL)) countRejected
            FROM `order` o
            LEFT JOIN company c ON c.id = o.company_customer
            LEFT JOIN stage s ON s.id = o.current_stage_id
            GROUP BY c.id
        ';

        $data = Yii::$app->db->createCommand($sql)->queryAll();

        $countColumn = array_column($data, 'countAll');
        array_multisort($countColumn, SORT_DESC, $data);

        return $data;
    }
}