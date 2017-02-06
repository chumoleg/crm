<?php

use console\components\migration\Migration;

class m160603_005650_createSourceAndProcessTimings extends Migration
{
    public function up()
    {
        $this->createTable('source', [
            'id'          => self::PRIMARY_KEY,
            'name'        => 'VARCHAR(200) NOT NULL',
            'date_create' => self::TIMESTAMP_FIELD,
        ], self::TABLE_OPTIONS);

        $this->insert('source', ['id' => 1, 'name' => 'Основной источник', 'date_create' => date('Y-m-d H:i:s')]);

        $this->addColumn('order', 'source_id', self::INT_FIELD_NOT_NULL . ' AFTER id');
        $this->update('order', ['source_id' => 1]);
        $this->addForeignKey('fk_order_source_id', 'order', 'source_id', 'source', 'id', 'RESTRICT', 'CASCADE');

        $this->createTable('process_source', [
            'id'          => self::PRIMARY_KEY,
            'process_id'  => self::INT_FIELD_NOT_NULL,
            'source_id'   => self::INT_FIELD_NOT_NULL,
            'date_create' => self::TIMESTAMP_FIELD,
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_process_source_process_id', 'process_source', 'process_id',
            'process', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_process_source_source_id', 'process_source', 'source_id',
            'source', 'id', 'CASCADE', 'CASCADE');

        $this->addColumn('process_action', 'working_time', self::INT_FIELD_NOT_NULL . ' AFTER action');

        $this->addColumn('order_process_history', 'need_working_time', self::INT_FIELD . ' AFTER process_action_id');
        $this->addColumn('order_process_history', 'fact_working_time', self::INT_FIELD . ' AFTER need_working_time');
    }

    public function down()
    {
        $this->dropTable('process_source');

        $this->dropForeignKey('fk_order_source_id', 'order');
        $this->dropColumn('order', 'source_id');

        $this->dropTable('source');

        $this->dropColumn('process_action', 'working_time');
        $this->dropColumn('order_process_history', 'fact_working_time');
        $this->dropColumn('order_process_history', 'need_working_time');
    }
}
