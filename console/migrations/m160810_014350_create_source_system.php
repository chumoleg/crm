<?php

use console\components\migration\Migration;

class m160810_014350_create_source_system extends Migration
{
    public function up()
    {
        try {
            $this->dropColumn('source', 'url');
        } catch (\Exception $e) {
        }

        try {
            $this->renameColumn('system_stage', 'foreign_number', 'foreign_status');
        } catch (\Exception $e) {
        }

        $this->createTable('source_system', [
            'id'          => self::PRIMARY_KEY,
            'source_id'   => self::INT_FIELD_NOT_NULL,
            'system_id'   => self::INT_FIELD_NOT_NULL,
            'date_create' => self::TIMESTAMP_FIELD
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_source_system_source_id', 'source_system', 'source_id',
            'source', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_source_system_system_id', 'source_system', 'system_id',
            'system', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('fk_source_system_source_id', 'source_system');
        $this->dropForeignKey('fk_source_system_system_id', 'source_system');
        $this->dropTable('source_system');
    }
}
