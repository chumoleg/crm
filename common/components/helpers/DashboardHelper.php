<?php

namespace common\components\helpers;

use Yii;
use yii\db\Query;
use common\models\company\Company;
use common\models\order\Order;
use common\models\stage\Stage;

class DashboardHelper
{
    public static function getData()
    {
        $query = new Query();

        return $query
            ->select([
                'countClients'              => 'COUNT(IF(c.type = 1, c.id, NULL))',
                'countOrders'               => 'COUNT(o.id)',
                'countActive'               => 'COUNT(IF(s.alias NOT IN ("close", "rejected"), o.id, NULL))',
                'countActiveOverdue'        => 'COUNT(IF(s.alias NOT IN ("close", "rejected") AND o.time_postponed IS NOT NULL AND o.time_postponed < NOW(), o.id, NULL))',
                'countRejected'             => 'COUNT(IF(s.alias = "rejected", o.id, NULL))',
                'countClosed'               => 'COUNT(IF(s.alias = "close", o.id, NULL))',
                'countClientsWithoutOrders' => 'COUNT(IF(o.id IS NULL, c.id, NULL))',
            ])
            ->from(Company::tableName() . ' c')
            ->leftJoin(Order::tableName() . ' o', 'o.company_customer = c.id')
            ->leftJoin(Stage::tableName() . ' s', 's.id = o.current_stage_id')
            ->createCommand()
            ->queryOne();
    }
}