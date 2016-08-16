<?php

namespace common\commands;

use Yii;
use yii\console\Controller;

class DbController extends Controller
{
    public function actionClearData()
    {
        $db = Yii::$app->db;
        $db->createCommand('SET FOREIGN_KEY_CHECKS = 0')->execute();

        $db->createCommand()->truncateTable('client')->execute();
        $db->createCommand()->truncateTable('client_address')->execute();
        $db->createCommand()->truncateTable('client_phone')->execute();
        $db->createCommand()->truncateTable('client_personal_data')->execute();

        $db->createCommand()->truncateTable('order')->execute();
        $db->createCommand()->truncateTable('order_call_history')->execute();
        $db->createCommand()->truncateTable('order_comment')->execute();
        $db->createCommand()->truncateTable('order_product')->execute();
        $db->createCommand()->truncateTable('order_stage')->execute();

        $db->createCommand()->truncateTable('comment')->execute();

        $db->createCommand()->truncateTable('process')->execute();
        $db->createCommand()->truncateTable('process_stage')->execute();
        $db->createCommand()->truncateTable('process_stage_action')->execute();
        $db->createCommand()->truncateTable('process_source')->execute();
        $db->createCommand()->truncateTable('product')->execute();
        $db->createCommand()->truncateTable('product_price')->execute();

        $db->createCommand('SET FOREIGN_KEY_CHECKS = 1')->execute();
    }
}