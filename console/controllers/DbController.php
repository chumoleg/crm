<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;

class DbController extends Controller
{
    public function actionClearOrder()
    {
        $db = Yii::$app->db;
        $db->createCommand('SET FOREIGN_KEY_CHECKS = 0')->execute();

        $db->createCommand()->truncateTable('order')->execute();
        $db->createCommand()->truncateTable('order_call_history')->execute();
        $db->createCommand()->truncateTable('order_comment')->execute();
        $db->createCommand()->truncateTable('order_product')->execute();
        $db->createCommand()->truncateTable('order_stage')->execute();
        $db->createCommand()->truncateTable('comment')->execute();

        $db->createCommand('SET FOREIGN_KEY_CHECKS = 1')->execute();
    }

    public function actionClearAll()
    {
        $db = Yii::$app->db;
        $db->createCommand('SET FOREIGN_KEY_CHECKS = 0')->execute();

        $db->createCommand()->truncateTable('order')->execute();
        $db->createCommand()->truncateTable('order_call_history')->execute();
        $db->createCommand()->truncateTable('order_comment')->execute();
        $db->createCommand()->truncateTable('order_product')->execute();
        $db->createCommand()->truncateTable('order_stage')->execute();

        $db->createCommand()->truncateTable('comment')->execute();

        $db->createCommand()->truncateTable('process')->execute();
        $db->createCommand()->truncateTable('process_stage')->execute();
        $db->createCommand()->truncateTable('process_stage_action')->execute();
        $db->createCommand()->truncateTable('process_stage_operator')->execute();
        $db->createCommand()->truncateTable('process_stage_action_reason')->execute();
        $db->createCommand()->truncateTable('process_source')->execute();

        $db->createCommand()->truncateTable('product')->execute();
        $db->createCommand()->truncateTable('product_price')->execute();
        $db->createCommand()->truncateTable('product_tag')->execute();

        $db->createCommand()->truncateTable('company')->execute();
        $db->createCommand()->truncateTable('company_contact')->execute();

        $db->createCommand()->truncateTable('geo_address')->execute();

        $db->createCommand()->truncateTable('source_system')->execute();
        $db->createCommand()->truncateTable('system')->execute();
        $db->createCommand()->truncateTable('system_product')->execute();
        $db->createCommand()->truncateTable('system_stage')->execute();
        $db->createCommand()->truncateTable('system_url')->execute();

        $db->createCommand()->truncateTable('wh_order_transaction')->execute();
        $db->createCommand()->truncateTable('wh_product_component')->execute();
        $db->createCommand()->truncateTable('wh_product_component_stock')->execute();
        $db->createCommand()->truncateTable('wh_product_tech_list')->execute();
        $db->createCommand()->truncateTable('wh_tech_list')->execute();
        $db->createCommand()->truncateTable('wh_tech_list_product_component')->execute();
        $db->createCommand()->truncateTable('wh_transaction')->execute();
        $db->createCommand()->truncateTable('wh_transaction_product_component')->execute();

        $db->createCommand()->truncateTable('user_tag')->execute();
        $db->createCommand()->truncateTable('user_history')->execute();

        $db->createCommand()->truncateTable('tag')->execute();

        $db->createCommand()->truncateTable('stage_method')->execute();

        $db->createCommand('SET FOREIGN_KEY_CHECKS = 1')->execute();
    }
}