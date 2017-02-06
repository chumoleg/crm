<?php

use console\components\migration\Migration;

class m170129_055244_create_global_history extends Migration
{
    public function up()
    {
        $this->createTable(
            'history',
            [
                'id'          => self::PRIMARY_KEY,
                'type'        => self::TINYINT_FIELD,
                'model'       => self::VARCHAR_FIELD,
                'data'        => 'TEXT DEFAULT NULL',
                'user_id'     => self::INT_FIELD_NOT_NULL,
                'date_create' => self::TIMESTAMP_FIELD,
            ],
            self::TABLE_OPTIONS
        );

        $this->addForeignKey('fk_history_user_id', 'history', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('fk_history_user_id', 'history');
        $this->dropTable('history');
    }
}
