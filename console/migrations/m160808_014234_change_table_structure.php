<?php

use common\components\migration\Migration;

class m160808_014234_change_table_structure extends Migration
{
    public function up()
    {
        $this->delete('process');
        $this->delete('stage');

        $this->createTable('action', [
            'id'          => self::PRIMARY_KEY,
            'name'        => 'VARCHAR(100) NOT NULL',
            'hold'        => self::TINYINT_FIELD,
            'date_create' => self::TIMESTAMP_FIELD
        ], self::TABLE_OPTIONS);

        try {
            $this->renameColumn('process_stage_action', 'action', 'action_id');
            $this->alterColumn('process_stage_action', 'action_id', self::INT_FIELD_NOT_NULL);
        } catch (\Exception $e) {
        }

        $this->addForeignKey('fk_process_stage_action_action_id', 'process_stage_action',
            'action_id', 'action', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('reason', [
            'id'          => self::PRIMARY_KEY,
            'name'        => 'VARCHAR(100) NOT NULL',
            'date_create' => self::TIMESTAMP_FIELD
        ], self::TABLE_OPTIONS);

        $this->createTable('process_stage_action_reason', [
            'id'                      => self::PRIMARY_KEY,
            'process_stage_action_id' => self::INT_FIELD_NOT_NULL,
            'reason_id'               => self::INT_FIELD_NOT_NULL,
            'date_create'             => self::TIMESTAMP_FIELD
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_process_stage_action_reason_process_stage_action_id', 'process_stage_action_reason',
            'process_stage_action_id', 'process_stage_action', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_process_stage_action_reason_reason_id', 'process_stage_action_reason', 'reason_id',
            'reason', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('stage_source', [
            'id'          => self::PRIMARY_KEY,
            'stage_id'    => self::INT_FIELD_NOT_NULL,
            'source_id'   => self::INT_FIELD_NOT_NULL,
            'status'      => 'VARCHAR(100) NOT NULL',
            'date_create' => self::TIMESTAMP_FIELD
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_stage_source_stage_id', 'stage_source', 'stage_id',
            'stage', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_stage_source_source_id', 'stage_source', 'source_id',
            'source', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('fk_process_stage_action_action_id', 'process_stage_action');

        $this->dropForeignKey('fk_stage_source_stage_id', 'stage_source');
        $this->dropForeignKey('fk_stage_source_source_id', 'stage_source');
        $this->dropTable('stage_source');

        $this->dropForeignKey('fk_process_stage_action_reason_process_stage_action_id', 'process_stage_action_reason');
        $this->dropForeignKey('fk_process_stage_action_reason_reason_id', 'process_stage_action_reason');
        $this->dropTable('process_stage_action_reason');

        $this->dropTable('reason');
        $this->dropTable('action');
    }
}
