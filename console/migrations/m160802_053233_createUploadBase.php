<?php

use console\components\migration\Migration;

class m160802_053233_createUploadBase extends Migration
{
    public function up()
    {
        $this->createTable('client_base_file', [
            'id'          => self::PRIMARY_KEY,
            'client_name' => 'VARCHAR(200) NOT NULL',
            'server_name' => 'VARCHAR(200) NOT NULL',
            'date_create' => self::TIMESTAMP_FIELD
        ], self::TABLE_OPTIONS);

        $this->createTable('client_base_file_data', [
            'id'                  => self::PRIMARY_KEY,
            'client_base_file_id' => self::INT_FIELD_NOT_NULL,
            'fio'                 => 'VARCHAR(300)',
            'phone'               => 'VARCHAR(300)',
            'data'                => 'TEXT',
            'duplicate_hash'      => 'CHAR(32) NOT NULL',
            'date_create'         => self::TIMESTAMP_FIELD
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_client_base_file_data_client_base_file_id', 'client_base_file_data',
            'client_base_file_id', 'client_base_file', 'id', 'RESTRICT', 'CASCADE');

        $this->createIndex('index_duplicate_hash', 'client_base_file_data', 'duplicate_hash', true);
    }

    public function down()
    {
        $this->dropForeignKey('fk_client_base_file_data_client_base_file_id', 'client_base_file_data');
        $this->dropTable('client_base_file_data');

        $this->dropTable('client_base_file');
    }
}
