<?php

use common\components\migration\Migration;

class m160816_101927_create_warehouse extends Migration
{
    public function up()
    {
        $this->createTable('wh_product_component', [
            'id'          => self::PRIMARY_KEY,
            'name'        => self::VARCHAR_FIELD,
            'date_create' => self::TIMESTAMP_FIELD
        ], self::TABLE_OPTIONS);

        $this->createTable('wh_tech_list', [
            'id'          => self::PRIMARY_KEY,
            'name'        => self::VARCHAR_FIELD,
            'date_create' => self::TIMESTAMP_FIELD
        ], self::TABLE_OPTIONS);

        $this->createTable('wh_tech_list_product_component', [
            'id'                   => self::PRIMARY_KEY,
            'tech_list_id'         => self::INT_FIELD_NOT_NULL,
            'product_component_id' => self::INT_FIELD_NOT_NULL,
            'quantity'             => self::INT_FIELD_NOT_NULL,
            'date_create'          => self::TIMESTAMP_FIELD
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_tech_list_product_component_tech_list_id', 'wh_tech_list_product_component',
            'tech_list_id', 'wh_tech_list', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_tech_list_product_component_product_component_id', 'wh_tech_list_product_component',
            'product_component_id', 'wh_product_component', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('wh_product_tech_list', [
            'id'           => self::PRIMARY_KEY,
            'product_id'   => self::INT_FIELD_NOT_NULL,
            'tech_list_id' => self::INT_FIELD_NOT_NULL,
            'priority'     => 'TINYINT UNSIGNED DEFAULT 1',
            'date_create'  => self::TIMESTAMP_FIELD
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_product_tech_list_product_id', 'wh_product_tech_list',
            'product_id', 'product', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_product_tech_list_tech_list_id', 'wh_product_tech_list',
            'tech_list_id', 'wh_tech_list', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('wh_product_component_stock', [
            'id'                   => self::PRIMARY_KEY,
            'product_component_id' => self::INT_FIELD_NOT_NULL,
            'quantity'             => self::INT_FIELD_NOT_NULL,
            'status'               => 'TINYINT(1) UNSIGNED DEFAULT 0',
            'date_create'          => self::TIMESTAMP_FIELD,
            'date_update'          => self::TIMESTAMP_FIELD,
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_product_component_stock_product_component_id', 'wh_product_component_stock',
            'product_component_id', 'wh_product_component', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('wh_transaction', [
            'id'          => self::PRIMARY_KEY,
            'type'        => self::TINYINT_FIELD,
            'name'        => self::VARCHAR_FIELD,
            'date_create' => self::TIMESTAMP_FIELD
        ], self::TABLE_OPTIONS);

        $this->createTable('wh_transaction_product_component', [
            'id'                   => self::PRIMARY_KEY,
            'transaction_id'       => self::INT_FIELD_NOT_NULL,
            'product_component_id' => self::INT_FIELD_NOT_NULL,
            'quantity'             => self::INT_FIELD_NOT_NULL,
            'date_create'          => self::TIMESTAMP_FIELD
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_transaction_product_component_transaction_id', 'wh_transaction_product_component',
            'transaction_id', 'wh_transaction', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_transaction_product_component_product_component_id',
            'wh_transaction_product_component',
            'product_component_id', 'wh_product_component', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('fk_transaction_product_component_transaction_id', 'wh_transaction_product_component');
        $this->dropForeignKey('fk_transaction_product_component_product_component_id',
            'wh_transaction_product_component');
        $this->dropTable('wh_transaction_product_component');

        $this->dropForeignKey('fk_product_component_stock_product_component_id', 'wh_product_component_stock');
        $this->dropTable('wh_product_component_stock');

        $this->dropForeignKey('fk_product_tech_list_product_id', 'wh_product_tech_list');
        $this->dropForeignKey('fk_product_tech_list_tech_list_id', 'wh_product_tech_list');
        $this->dropTable('wh_product_tech_list');

        $this->dropForeignKey('fk_tech_list_product_component_tech_list_id', 'wh_tech_list_product_component');
        $this->dropForeignKey('fk_tech_list_product_component_product_component_id', 'wh_tech_list_product_component');
        $this->dropTable('wh_tech_list_product_component');

        $this->dropTable('wh_tech_list');
        $this->dropTable('wh_product_component');
        $this->dropTable('wh_transaction');
    }
}
