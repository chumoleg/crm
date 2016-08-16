<?php

use common\components\migration\Migration;

class m160725_065310_createStages extends Migration
{
    public function up()
    {
        $this->delete('process');

        $this->createTable('stage', [
            'id'          => self::PRIMARY_KEY,
            'name'        => 'VARCHAR(300) NOT NULL',
            'alias'       => 'VARCHAR(300) NOT NULL',
            'user_id'     => self::INT_FIELD,
            'date_create' => self::TIMESTAMP_FIELD
        ], self::TABLE_OPTIONS);

        $this->addColumn('process_stage', 'stage_id', self::INT_FIELD_NOT_NULL . ' AFTER process_id');
        $this->addForeignKey('fk_process_stage_stage_id', 'process_stage', 'stage_id',
            'stage', 'id', 'RESTRICT', 'CASCADE');

        try {
            $this->dropColumn('process_stage', 'name');
            $this->dropColumn('process_stage', 'alias');
        } catch (\Exception $e) {
        }

        $this->delete('order');
        try {
            $this->dropForeignKey('fk_order_progress_process_stage_id', 'order_progress');
            $this->dropForeignKey('fk_order_progress_order_id', 'order_progress');
        } catch (\Exception $e) {
        }

        try {
            $this->renameTable('order_progress', 'order_stage');
        } catch (\Exception $e) {
        }

        try {
            $this->renameColumn('order_stage', 'process_stage_id', 'stage_id');
        } catch (\Exception $e) {
        }

        try {
            $this->addForeignKey('fk_order_stage_order_id', 'order_stage', 'order_id',
                'order', 'id', 'CASCADE', 'CASCADE');
            $this->addForeignKey('fk_order_stage_stage_id', 'order_stage', 'stage_id',
                'stage', 'id', 'CASCADE', 'CASCADE');
        } catch (\Exception $e) {
        }

        try {
            $this->dropForeignKey('fk_process_stage_action_follow_to_process_stage_id', 'process_stage_action');

            $this->renameColumn('process_stage_action', 'follow_to_process_stage_id', 'follow_to_stage_id');
            $this->addForeignKey('fk_process_stage_action_follow_to_stage_id', 'process_stage_action',
                'follow_to_stage_id', 'stage', 'id', 'CASCADE', 'CASCADE');
        } catch (\Exception $e) {
        }
    }

    public function down()
    {
        $this->dropForeignKey('fk_process_stage_stage_id', 'process_stage');
        $this->dropColumn('process_stage', 'stage_id');

        $this->dropTable('stage');
    }
}
