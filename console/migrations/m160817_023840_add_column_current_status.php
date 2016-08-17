<?php

use common\components\migration\Migration;

class m160817_023840_add_column_current_status extends Migration
{
    public function up()
    {
        $this->alterColumn('order', 'process_id', self::INT_FIELD . ' AFTER source_id');
        $this->addColumn('order', 'current_stage_id', self::INT_FIELD . ' AFTER process_id');

        $this->addForeignKey('fk_order_current_stage_id', 'order', 'current_stage_id',
            'stage', 'id', 'SET NULL', 'CASCADE');

        $this->delete('order_stage', 'stage_id NOT IN (SELECT id FROM stage)');
        $this->addForeignKey('fk_order_stage_stage_id', 'order_stage', 'stage_id',
            'stage', 'id', 'RESTRICT', 'CASCADE');

        $this->execute('UPDATE `order` o SET o.current_stage_id = 
            (SELECT stage_id FROM order_stage WHERE order_id = o.id AND status = 1 LIMIT 1)');

        try {
            $this->dropColumn('order', 'status');
        } catch (\Exception $e) {
        }

        try {
            $this->createIndex('index_order_status', 'order_stage', 'order_id,status');
        } catch (\Exception $e){
        }
    }

    public function down()
    {
        $this->dropForeignKey('fk_order_stage_stage_id', 'order_stage');

        $this->dropForeignKey('fk_order_current_stage_id', 'order');
        $this->dropColumn('order', 'current_stage_id');

        try {
            $this->dropIndex('index_order_status', 'order_stage');
        } catch (\Exception $e){
        }
    }
}
