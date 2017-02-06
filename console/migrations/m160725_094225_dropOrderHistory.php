<?php

use console\components\migration\Migration;

class m160725_094225_dropOrderHistory extends Migration
{
    public function up()
    {
        try {
            $this->dropForeignKey('fk_order_history_order_id', 'order_history');
            $this->dropForeignKey('fk_order_history_process_stage_action_id', 'order_history');
            $this->dropTable('order_history');

        } catch (\Exception $e){
        }
    }

    public function down()
    {
    }
}
