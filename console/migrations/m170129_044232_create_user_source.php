<?php

use console\components\migration\Migration;

class m170129_044232_create_user_source extends Migration
{
    public function up()
    {
        $this->createTable('user_source', [
            'id'        => self::PRIMARY_KEY,
            'user_id'   => self::INT_FIELD_NOT_NULL,
            'source_id' => self::INT_FIELD_NOT_NULL,
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_user_source_user_id', 'user_source', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_user_source_source_id', 'user_source', 'source_id',
            'source', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('fk_user_source_source_id', 'user_source');
        $this->dropForeignKey('fk_user_source_user_id', 'user_source');
        $this->dropTable('user_source');
    }
}
