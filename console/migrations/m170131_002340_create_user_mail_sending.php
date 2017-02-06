<?php

use console\components\migration\Migration;

class m170131_002340_create_user_mail_sending extends Migration
{
    public function up()
    {
        $this->createTable(
            'user_mail_sending',
            [
                'id'          => self::PRIMARY_KEY,
                'user_id'     => self::INT_FIELD_NOT_NULL,
                'type'        => self::TINYINT_FIELD,
                'date_create' => self::TIMESTAMP_FIELD,
            ],
            self::TABLE_OPTIONS
        );

        $this->addForeignKey(
            'fk_user_mail_sending_user_id',
            'user_mail_sending',
            'user_id',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk_user_mail_sending_user_id', 'user_mail_sending');
        $this->dropTable('user_mail_sending');
    }
}
