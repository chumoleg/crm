<?php

use common\components\migration\Migration;

class m160719_030254_changeProcessStageStructure extends Migration
{
    public function up()
    {
        try {
            $this->dropForeignKey('fk_process_stage_stage_id', 'process_stage');
            $this->dropColumn('process_stage', 'stage_id');
        } catch (\Exception $e) {
        }

        $this->addColumn('process_stage', 'name', 'VARCHAR(300) NOT NULL AFTER process_id');
        $this->addColumn('process_stage', 'time_limit', self::INT_FIELD_NOT_NULL . ' AFTER name');

        try {
            $this->dropForeignKey('fk_order_history_process_stage_id', 'order_history');
            $this->dropColumn('order_history', 'process_stage_id');
            $this->dropColumn('order_history', 'action');
        } catch (\Exception $e) {
        }

        $this->createTable('process_stage_action', [
            'id'                         => self::PRIMARY_KEY,
            'process_stage_id'           => self::INT_FIELD_NOT_NULL,
            'action'                     => self::INT_FIELD_NOT_NULL,
            'follow_to_process_stage_id' => self::INT_FIELD,
            'user_id'                    => self::INT_FIELD_NOT_NULL,
            'date_create'                => self::TIMESTAMP_FIELD
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_process_stage_action_process_stage_id', 'process_stage_action', 'process_stage_id',
            'process_stage', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_process_stage_action_follow_to_process_stage_id', 'process_stage_action',
            'follow_to_process_stage_id', 'process_stage', 'id', 'SET NULL', 'CASCADE');

        $this->addColumn('order_history', 'process_stage_action_id', self::INT_FIELD_NOT_NULL . ' AFTER order_id');
        $this->addForeignKey('fk_order_history_process_stage_action_id', 'order_history', 'process_stage_action_id',
            'process_stage_action', 'id', 'CASCADE', 'CASCADE');

        try {
            $this->dropForeignKey('fk_order_progress_process_id', 'order_progress');
            $this->dropForeignKey('fk_order_progress_stage_id', 'order_progress');
            $this->dropColumn('order_progress', 'process_id');
            $this->dropColumn('order_progress', 'stage_id');
        } catch (\Exception $e) {
        }

        $this->delete('order_progress');
        $this->addColumn('order_progress', 'process_stage_id', self::INT_FIELD_NOT_NULL . ' AFTER order_id');
        $this->addForeignKey('fk_order_progress_process_stage_id', 'order_progress', 'process_stage_id',
            'process_stage', 'id', 'CASCADE', 'CASCADE');

        try {
            $this->dropForeignKey('fk_stage_action_stage_id', 'stage_action');
            $this->dropTable('stage_action');
        } catch (\Exception $e) {
        }

        try {
            $this->dropTable('stage');
        } catch (\Exception $e) {
        }
    }

    public function down()
    {
        $this->dropForeignKey('fk_order_progress_process_stage_id', 'order_progress');
        $this->dropColumn('order_progress', 'process_stage_id');

        $this->dropForeignKey('fk_order_history_process_stage_action_id', 'order_history');
        $this->dropColumn('order_history', 'process_stage_action_id');

        $this->dropColumn('process_stage', 'name');
        $this->dropColumn('process_stage', 'time_limit');

        $this->dropForeignKey('fk_process_stage_action_process_stage_id', 'process_stage_action');
        $this->dropForeignKey('fk_process_stage_action_follow_to_process_stage_id', 'process_stage_action');
        $this->dropTable('process_stage_action');
    }
}
