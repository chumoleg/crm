<?php

use console\components\migration\Migration;

class m160728_094818_createProcessStageUser extends Migration
{
    public function up()
    {
        $this->addColumn('process_stage', 'type_search_operator', 'TINYINT(1) UNSIGNED DEFAULT 1 AFTER time_unit');

        $this->createTable('process_stage_operator', [
            'id'          => self::PRIMARY_KEY,
            'process_id'  => self::INT_FIELD_NOT_NULL,
            'stage_id'    => self::INT_FIELD_NOT_NULL,
            'operator_id' => self::INT_FIELD_NOT_NULL,
            'user_id'     => self::INT_FIELD,
            'date_create' => self::TIMESTAMP_FIELD
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_process_stage_operator_process_id', 'process_stage_operator', 'process_id',
            'process', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_process_stage_operator_stage_id', 'process_stage_operator', 'stage_id',
            'stage', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_process_stage_operator_operator_id', 'process_stage_operator', 'operator_id',
            'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_process_stage_operator_user_id', 'process_stage_operator', 'user_id',
            'user', 'id', 'SET NULL', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('fk_process_stage_operator_process_id', 'process_stage_operator');
        $this->dropForeignKey('fk_process_stage_operator_stage_id', 'process_stage_operator');
        $this->dropForeignKey('fk_process_stage_operator_operator_id', 'process_stage_operator');
        $this->dropForeignKey('fk_process_stage_operator_user_id', 'process_stage_operator');
        $this->dropTable('process_stage_operator');

        $this->dropColumn('process_stage', 'type_search_operator');
    }
}
