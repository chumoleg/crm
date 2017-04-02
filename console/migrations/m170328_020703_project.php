<?php

use common\components\migration\Migration;

class m170328_020703_project extends Migration
{
    public function up()
    {
        $this->createTable('project', [
            'id'                   => self::PRIMARY_KEY,
            'name'                 => 'VARCHAR(200) NOT NULL',
            'label_class'          => 'VARCHAR(100) DEFAULT NULL',
            'comment'              => 'VARCHAR(2000)',
            'user_id'              => self::INT_FIELD_NOT_NULL,
            'status'               => self::TINYINT_FIELD,
            'date_create'          => self::TIMESTAMP_FIELD,
        ], self::TABLE_OPTIONS);

        $this->createTable('user_project', [
            'id'          => self::PRIMARY_KEY,
            'user_id'     => self::INT_FIELD_NOT_NULL,
            'project_id'      => self::INT_FIELD_NOT_NULL,
            'date_create' => self::TIMESTAMP_FIELD
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_user_project_user_id', 'user_project', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_user_project_project_id', 'user_project', 'project_id', 'project', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('fk_user_project_user_id', 'user_project');
        $this->dropForeignKey('fk_user_project_project_id', 'user_project');
        $this->dropTable('user_project');

        $this->dropTable('project');
    }
}
