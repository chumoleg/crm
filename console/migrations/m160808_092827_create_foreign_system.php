<?php

use common\components\migration\Migration;

class m160808_092827_create_foreign_system extends Migration
{
    public function up()
    {
        try {
            $this->dropForeignKey('fk_stage_source_stage_id', 'stage_source');
            $this->dropForeignKey('fk_stage_source_source_id', 'stage_source');
            $this->dropTable('stage_source');

        } catch (\Exception $e) {
        }

        $this->createTable('system', [
            'id'          => self::PRIMARY_KEY,
            'name'        => 'VARCHAR(200) NOT NULL',
            'date_create' => self::TIMESTAMP_FIELD
        ], self::TABLE_OPTIONS);

        $this->createTable('system_product', [
            'id'             => self::PRIMARY_KEY,
            'system_id'      => self::INT_FIELD_NOT_NULL,
            'product_id'     => self::INT_FIELD_NOT_NULL,
            'foreign_number' => 'VARCHAR(100) NOT NULL',
            'date_create'    => self::TIMESTAMP_FIELD
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_system_product_system_id', 'system_product', 'system_id',
            'system', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_system_product_product_id', 'system_product', 'product_id',
            'product', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('system_stage', [
            'id'             => self::PRIMARY_KEY,
            'system_id'      => self::INT_FIELD_NOT_NULL,
            'stage_id'       => self::INT_FIELD_NOT_NULL,
            'foreign_number' => 'VARCHAR(100) NOT NULL',
            'date_create'    => self::TIMESTAMP_FIELD
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_system_stage_system_id', 'system_stage', 'system_id',
            'system', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_system_stage_stage_id', 'system_stage', 'stage_id',
            'stage', 'id', 'CASCADE', 'CASCADE');


        $this->createTable('system_url', [
            'id'          => self::PRIMARY_KEY,
            'system_id'   => self::INT_FIELD_NOT_NULL,
            'type'        => 'TINYINT UNSIGNED NOT NULL',
            'url'         => 'VARCHAR(300) NOT NULL',
            'date_create' => self::TIMESTAMP_FIELD
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_system_url_system_id', 'system_url', 'system_id',
            'system', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('fk_system_url_system_id', 'system_url');
        $this->dropTable('system_url');

        $this->dropForeignKey('fk_system_stage_system_id', 'system_stage');
        $this->dropForeignKey('fk_system_stage_stage_id', 'system_stage');
        $this->dropTable('system_stage');

        $this->dropForeignKey('fk_system_product_product_id', 'system_product');
        $this->dropForeignKey('fk_system_product_system_id', 'system_product');
        $this->dropTable('system_product');

        $this->dropTable('system');
    }
}
