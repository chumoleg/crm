<?php

use console\components\migration\Migration;

class m160606_012441_changeStructure extends Migration
{
    public function up()
    {
        $this->_createStage();
        $this->_createStageAction();
        $this->_createProcessStage();
        $this->_createOrderHistory();

        try {
            $this->dropTable('process_action');
        } catch (\Exception $e) {
        }

        try {
            $this->dropTable('order_process');
        } catch (\Exception $e) {
        }

        try {
            $this->dropTable('order_process_history');
        } catch (\Exception $e) {
        }

    }

    public function down()
    {
        $this->dropForeignKey('fk_process_stage_process_id', 'process_stage');
        $this->dropForeignKey('fk_process_stage_stage_id', 'process_stage');
        $this->dropForeignKey('fk_stage_action_stage_id', 'stage_action');
        $this->dropForeignKey('fk_order_history_order_id', 'order_history');
        $this->dropForeignKey('fk_order_history_process_stage_id', 'order_history');

        $this->dropTable('stage_action');
        $this->dropTable('process_stage');
        $this->dropTable('order_history');
        $this->dropTable('stage');
    }

    private function _createOrderHistory()
    {
        $this->createTable('order_history', [
            'id'               => self::PRIMARY_KEY,
            'order_id'         => self::INT_FIELD_NOT_NULL,
            'process_stage_id' => self::INT_FIELD_NOT_NULL,
            'status'           => self::TINYINT_FIELD . ' DEFAULT 1',
            'action'           => self::INT_FIELD_NOT_NULL,
            'user_id'          => self::INT_FIELD_NOT_NULL,
            'date_create'      => self::TIMESTAMP_FIELD,
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_order_history_order_id', 'order_history',
            'order_id', 'order', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_order_history_process_stage_id', 'order_history',
            'process_stage_id', 'process_stage', 'id', 'RESTRICT', 'CASCADE');
    }

    private function _createProcessStage()
    {
        $this->createTable('process_stage', [
            'id'          => self::PRIMARY_KEY,
            'process_id'  => self::INT_FIELD_NOT_NULL,
            'stage_id'    => self::INT_FIELD_NOT_NULL,
            'user_id'     => self::INT_FIELD_NOT_NULL,
            'date_create' => self::TIMESTAMP_FIELD,
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_process_stage_process_id', 'process_stage', 'process_id',
            'process', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_process_stage_stage_id', 'process_stage', 'stage_id',
            'stage', 'id', 'CASCADE', 'CASCADE');
    }

    private function _createStage()
    {
        $this->createTable('stage', [
            'id'           => self::PRIMARY_KEY,
            'name'         => 'VARCHAR(200) NOT NULL',
            'working_time' => self::INT_FIELD_NOT_NULL,
            'user_id'      => self::INT_FIELD_NOT_NULL,
            'date_create'  => self::TIMESTAMP_FIELD,
        ], self::TABLE_OPTIONS);
    }

    private function _createStageAction()
    {
        $this->createTable('stage_action', [
            'id'          => self::PRIMARY_KEY,
            'stage_id'    => self::INT_FIELD_NOT_NULL,
            'action'      => self::INT_FIELD_NOT_NULL,
            'user_id'     => self::INT_FIELD_NOT_NULL,
            'date_create' => self::TIMESTAMP_FIELD,
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_stage_action_stage_id', 'stage_action', 'stage_id',
            'stage', 'id', 'CASCADE', 'CASCADE');
    }
}
