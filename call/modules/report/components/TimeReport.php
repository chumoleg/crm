<?php

namespace call\modules\report\components;

use Yii;

class TimeReport
{
    public function getData()
    {
        $sql = '
            SELECT 
                s.name stageName, 
                SUM(os.time_spent) timeSpent, 
                COUNT(DISTINCT os.order_id) countOrders, 
                COUNT(os.overdue) countOverdue
            FROM order_stage os
            LEFT JOIN user u ON u.id = os.user_id
            LEFT JOIN stage s ON s.id = os.stage_id
            GROUP BY os.stage_id
        ';

        return Yii::$app->db->createCommand($sql)->queryAll();
    }
}