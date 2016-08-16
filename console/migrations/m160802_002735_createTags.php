<?php

use common\components\migration\Migration;

class m160802_002735_createTags extends Migration
{
    public function up()
    {
        $this->createTable('tag', [
            'id'          => self::PRIMARY_KEY,
            'name'        => 'VARCHAR(200) NOT NULL',
            'label_class' => 'VARCHAR(100) DEFAULT NULL',
            'user_id'     => self::INT_FIELD_NOT_NULL,
            'date_create' => self::TIMESTAMP_FIELD,
        ], self::TABLE_OPTIONS);

        $this->createTable('user_tag', [
            'id'          => self::PRIMARY_KEY,
            'user_id'     => self::INT_FIELD_NOT_NULL,
            'tag_id'      => self::INT_FIELD_NOT_NULL,
            'date_create' => self::TIMESTAMP_FIELD
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_user_tag_user_id', 'user_tag', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_user_tag_tag_id', 'user_tag', 'tag_id', 'tag', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('product_tag', [
            'id'          => self::PRIMARY_KEY,
            'product_id'  => self::INT_FIELD_NOT_NULL,
            'tag_id'      => self::INT_FIELD_NOT_NULL,
            'date_create' => self::TIMESTAMP_FIELD
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_product_tag_product_id', 'product_tag', 'product_id',
            'product', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_product_tag_tag_id', 'product_tag', 'tag_id', 'tag', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('fk_product_tag_product_id', 'product_tag');
        $this->dropForeignKey('fk_product_tag_tag_id', 'product_tag');
        $this->dropTable('product_tag');

        $this->dropForeignKey('fk_user_tag_user_id', 'user_tag');
        $this->dropForeignKey('fk_user_tag_tag_id', 'user_tag');
        $this->dropTable('user_tag');

        $this->dropTable('tag');
    }
}
