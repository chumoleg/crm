<?php

use console\components\migration\Migration;

class m160427_151334_createTables extends Migration
{
    private $_tableList
        = [
            'user',
            'geo_region',
            'geo_area',
            'geo_city',
            'geo_address',
            'comment',
            'user_history',
            'product',
            'product_price',
            'client',
            'client_personal_data',
            'client_contact',
            'client_address',
            'process',
            'process_action',
            'order',
            'order_process',
            'order_process_history',
            'order_product',
            'order_comment',
            'order_call_history',
        ];

    public function up()
    {
        $this->_createUser();

        $this->_createGeo();
        $this->_createGeoAddress();

        $this->_createComment();

        $this->_createUserHistory();

        $this->_createProduct();
        $this->_createProductPrice();

        $this->_createClient();
        $this->_createClientPersonalData();
        $this->_createClientContact();
        $this->_createClientAddress();

        $this->_createProcess();
        $this->_createProcessAction();

        $this->_createOrder();
        $this->_createOrderProcess();
        $this->_createOrderProcessHistory();
        $this->_createOrderProduct();
        $this->_createOrderComment();
        $this->_createOrderCallHistory();

        $this->addForeignKey('fk_auth_assignment_user_id', 'auth_assignment', 'user_id',
            'user', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');

        foreach ($this->_tableList as $tableName) {
            $this->dropTable($tableName);
        }

        $this->dropForeignKey('fk_auth_assignment_user_id', 'auth_assignment');

        $this->execute('SET foreign_key_checks = 1');
    }

    private function _createUser()
    {
        $this->createTable('user', [
            'id'                   => self::PRIMARY_KEY,
            'email'                => 'VARCHAR(64) NOT NULL',
            'fio'                  => 'VARCHAR(200) DEFAULT NULL',
            'role'                 => 'VARCHAR(50) NOT NULL',
            'password_hash'        => 'CHAR(60) NULL',
            'password_reset_token' => 'CHAR(44) NULL',
            'auth_key'             => 'CHAR(32) NOT NULL',
            'status'               => self::TINYINT_FIELD,
            'date_create'          => self::TIMESTAMP_FIELD,
        ], self::TABLE_OPTIONS);
    }

    private function _createGeo()
    {
        $this->createTable('geo_region', [
            'id'          => self::PRIMARY_KEY,
            'name'        => 'VARCHAR(150) NOT NULL',
            'date_create' => self::TIMESTAMP_FIELD,
        ], self::TABLE_OPTIONS);

        $this->createTable('geo_area', [
            'id'          => self::PRIMARY_KEY,
            'region_id'   => self::INT_FIELD_NOT_NULL,
            'name'        => 'VARCHAR(150) NOT NULL',
            'type'        => 'TINYINT(3) UNSIGNED NOT NULL',
            'date_create' => self::TIMESTAMP_FIELD,
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_geo_area_region_id', 'geo_area', 'region_id',
            'geo_region', 'id', 'RESTRICT', 'CASCADE');

        $this->createTable('geo_city', [
            'id'          => self::PRIMARY_KEY,
            'region_id'   => self::INT_FIELD_NOT_NULL,
            'area_id'     => self::INT_FIELD_NOT_NULL,
            'name'        => 'VARCHAR(150) NOT NULL',
            'type'        => 'TINYINT(3) UNSIGNED NOT NULL',
            'date_create' => self::TIMESTAMP_FIELD,
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_geo_city_region_id', 'geo_city', 'region_id',
            'geo_region', 'id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey('fk_geo_city_area_id', 'geo_city', 'area_id',
            'geo_area', 'id', 'RESTRICT', 'CASCADE');
    }

    private function _createGeoAddress()
    {
        $this->createTable('geo_address', [
            'id'           => self::PRIMARY_KEY,
            'post_index'   => 'VARCHAR(6) DEFAULT NULL',
            'region_id'    => self::INT_FIELD_NOT_NULL,
            'area_id'      => self::INT_FIELD_NOT_NULL,
            'city_id'      => self::INT_FIELD,
            'street'       => 'VARCHAR(100) DEFAULT NULL',
            'house'        => 'VARCHAR(50) DEFAULT NULL',
            'apartment'    => 'VARCHAR(50) DEFAULT NULL',
            'address_hash' => 'CHAR(32) NOT NULL',
            'date_create'  => self::TIMESTAMP_FIELD,
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_geo_address_region_id', 'geo_address', 'region_id',
            'geo_region', 'id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey('fk_geo_address_area_id', 'geo_address', 'area_id',
            'geo_area', 'id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey('fk_geo_address_city_id', 'geo_address', 'city_id',
            'geo_city', 'id', 'RESTRICT', 'CASCADE');
    }

    private function _createComment()
    {
        $this->createTable('comment', [
            'id'           => self::PRIMARY_KEY,
            'text'         => 'TEXT DEFAULT NULL',
            'comment_hash' => 'CHAR(32) NOT NULL',
            'user_id'      => self::INT_FIELD_NOT_NULL,
            'date_create'  => self::TIMESTAMP_FIELD,
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_comment_user_id', 'comment', 'user_id',
            'user', 'id', 'RESTRICT', 'CASCADE');
    }

    private function _createUserHistory()
    {
        $this->createTable('user_history', [
            'id'          => self::PRIMARY_KEY,
            'user_id'     => self::INT_FIELD_NOT_NULL,
            'action'      => self::INT_FIELD_NOT_NULL,
            'comment'     => self::INT_FIELD_NOT_NULL,
            'date_create' => self::TIMESTAMP_FIELD,
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_user_history_user_id', 'user_history', 'user_id',
            'user', 'id', 'RESTRICT', 'CASCADE');
    }

    private function _createProduct()
    {
        $this->createTable('product', [
            'id'          => self::PRIMARY_KEY,
            'name'        => 'VARCHAR(250) NOT NULL',
            'article'     => 'VARCHAR(100) NOT NULL',
            'description' => 'TEXT DEFAULT NULL',
            'category'    => 'TINYINT(3) UNSIGNED NOT NULL',
            'status'      => self::TINYINT_FIELD,
            'user_id'     => self::INT_FIELD,
            'date_create' => self::TIMESTAMP_FIELD,
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_product_user_id', 'product', 'user_id',
            'user', 'id', 'SET NULL', 'CASCADE');
    }

    private function _createProductPrice()
    {
        $this->createTable('product_price', [
            'id'          => self::PRIMARY_KEY,
            'product_id'  => self::INT_FIELD_NOT_NULL,
            'price'       => 'DECIMAL(12, 2) NOT NULL',
            'currency'    => 'TINYINT(3) UNSIGNED DEFAULT 1',
            'type'        => self::TINYINT_FIELD,
            'status'      => self::TINYINT_FIELD,
            'user_id'     => self::INT_FIELD,
            'date_create' => self::TIMESTAMP_FIELD,
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_product_price_product_id', 'product_price', 'product_id',
            'product', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_product_price_user_id', 'product_price', 'user_id',
            'user', 'id', 'SET NULL', 'CASCADE');
    }

    private function _createClient()
    {
        $this->createTable('client', [
            'id'          => self::PRIMARY_KEY,
            'type'        => self::TINYINT_FIELD,
            'is_new'      => 'TINYINT(1) UNSIGNED DEFAULT 1',
            'status'      => self::TINYINT_FIELD,
            'user_id'     => self::INT_FIELD,
            'date_create' => self::TIMESTAMP_FIELD,
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_client_user_id', 'client', 'user_id',
            'user', 'id', 'SET NULL', 'CASCADE');
    }

    private function _createClientPersonalData()
    {
        $this->createTable('client_personal_data', [
            'id'          => self::PRIMARY_KEY,
            'client_id'   => self::INT_FIELD_NOT_NULL,
            'fio'         => 'VARCHAR(300) NOT NULL',
            'main'        => self::TINYINT_FIELD,
            'user_id'     => self::INT_FIELD,
            'date_create' => self::TIMESTAMP_FIELD,
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_client_personal_data_user_id', 'client_personal_data', 'user_id',
            'user', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('fk_client_personal_data_client_id', 'client_personal_data', 'client_id',
            'client', 'id', 'CASCADE', 'CASCADE');
    }

    private function _createClientContact()
    {
        $this->createTable('client_contact', [
            'id'          => self::PRIMARY_KEY,
            'client_id'   => self::INT_FIELD_NOT_NULL,
            'type'        => 'TINYINT(3) UNSIGNED NOT NULL',
            'value'       => 'VARCHAR(300) NOT NULL',
            'main'        => self::TINYINT_FIELD,
            'user_id'     => self::INT_FIELD,
            'date_create' => self::TIMESTAMP_FIELD,
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_client_contact_user_id', 'client_contact', 'user_id',
            'user', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('fk_client_contact_client_id', 'client_contact', 'client_id',
            'client', 'id', 'CASCADE', 'CASCADE');
    }

    private function _createClientAddress()
    {
        $this->createTable('client_address', [
            'id'          => self::PRIMARY_KEY,
            'client_id'   => self::INT_FIELD_NOT_NULL,
            'address_id'  => self::INT_FIELD_NOT_NULL,
            'main'        => self::TINYINT_FIELD,
            'user_id'     => self::INT_FIELD,
            'date_create' => self::TIMESTAMP_FIELD,
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_client_address_user_id', 'client_address', 'user_id',
            'user', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('fk_client_address_client_id', 'client_address', 'client_id',
            'client', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_client_address_address_id', 'client_address', 'address_id',
            'geo_address', 'id', 'CASCADE', 'CASCADE');
    }

    private function _createProcess()
    {
        $this->createTable('process', [
            'id'          => self::PRIMARY_KEY,
            'type'        => 'TINYINT(3) UNSIGNED NOT NULL',
            'name'        => 'VARCHAR(100) NOT NULL',
            'status'      => self::TINYINT_FIELD,
            'user_id'     => self::INT_FIELD,
            'date_create' => self::TIMESTAMP_FIELD,
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_process_user_id', 'process', 'user_id',
            'user', 'id', 'SET NULL', 'CASCADE');
    }

    private function _createProcessAction()
    {
        $this->createTable('process_action', [
            'id'          => self::PRIMARY_KEY,
            'process_id'  => self::INT_FIELD_NOT_NULL,
            'action'      => 'TINYINT(3) UNSIGNED NOT NULL',
            'status'      => self::TINYINT_FIELD,
            'user_id'     => self::INT_FIELD,
            'date_create' => self::TIMESTAMP_FIELD,
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_process_action_user_id', 'process_action', 'user_id',
            'user', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('fk_process_action_process_id', 'process_action', 'process_id',
            'process', 'id', 'CASCADE', 'CASCADE');
    }

    private function _createOrder()
    {
        $this->createTable('order', [
            'id'              => self::PRIMARY_KEY,
            'status'          => 'TINYINT(3) UNSIGNED DEFAULT 1',
            'time_postponed'  => self::TIMESTAMP_FIELD,
            'client_id'       => self::INT_FIELD_NOT_NULL,
            'address_id'      => self::INT_FIELD,
            'process_id'      => self::INT_FIELD,
            'type_payment'    => 'TINYINT(3) UNSIGNED DEFAULT 1',
            'type_delivery'   => 'TINYINT(3) UNSIGNED DEFAULT 1',
            'price'           => 'DECIMAL(14, 2) DEFAULT 0',
            'delivery_price'  => 'DECIMAL(10, 2) DEFAULT 0',
            'currency'        => 'TINYINT(3) UNSIGNED DEFAULT 1',
            'current_user_id' => self::INT_FIELD,
            'create_user_id'  => self::INT_FIELD,
            'date_create'     => self::TIMESTAMP_FIELD,
            'date_update'     => self::TIMESTAMP_FIELD,
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_order_client_id', 'order', 'client_id',
            'client', 'id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey('fk_order_address_id', 'order', 'address_id',
            'geo_address', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('fk_order_process_id', 'order', 'process_id',
            'process', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('fk_order_current_user_id', 'order', 'current_user_id',
            'user', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('fk_order_create_user_id', 'order', 'create_user_id',
            'user', 'id', 'SET NULL', 'CASCADE');
    }

    private function _createOrderProcess()
    {
        $this->createTable('order_process', [
            'id'                => self::PRIMARY_KEY,
            'order_id'          => self::INT_FIELD_NOT_NULL,
            'process_action_id' => self::INT_FIELD_NOT_NULL
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_order_process_order_id', 'order_process', 'order_id',
            'order', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_order_process_process_action_id', 'order_process', 'process_action_id',
            'process_action', 'id', 'RESTRICT', 'CASCADE');
    }

    private function _createOrderProcessHistory()
    {
        $this->createTable('order_process_history', [
            'id'                => self::PRIMARY_KEY,
            'order_id'          => self::INT_FIELD_NOT_NULL,
            'process_action_id' => self::INT_FIELD_NOT_NULL,
            'status'            => self::TINYINT_FIELD,
            'user_id'           => self::INT_FIELD,
            'date_create'       => self::TIMESTAMP_FIELD,
            'date_update'       => self::TIMESTAMP_FIELD,
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_order_process_history_order_id', 'order_process_history', 'order_id',
            'order', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_order_process_history_process_action_id', 'order_process_history',
            'process_action_id', 'process_action', 'id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey('fk_order_process_history_user_id', 'order_process_history', 'user_id',
            'user', 'id', 'SET NULL', 'CASCADE');
    }

    private function _createOrderProduct()
    {
        $this->createTable('order_product', [
            'id'          => self::PRIMARY_KEY,
            'order_id'    => self::INT_FIELD_NOT_NULL,
            'product_id'  => self::INT_FIELD_NOT_NULL,
            'type'        => self::TINYINT_FIELD,
            'price'       => 'DECIMAL(12, 2) DEFAULT 0',
            'currency'    => 'TINYINT(3) UNSIGNED DEFAULT 1',
            'quantity'    => 'TINYINT(3) UNSIGNED DEFAULT 1',
            'user_id'     => self::INT_FIELD,
            'date_create' => self::TIMESTAMP_FIELD,
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_order_product_order_id', 'order_product', 'order_id',
            'order', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_order_product_product_id', 'order_product', 'product_id',
            'product', 'id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey('fk_order_product_user_id', 'order_product', 'user_id',
            'user', 'id', 'SET NULL', 'CASCADE');
    }

    private function _createOrderComment()
    {
        $this->createTable('order_comment', [
            'id'          => self::PRIMARY_KEY,
            'order_id'    => self::INT_FIELD_NOT_NULL,
            'comment_id'  => self::INT_FIELD_NOT_NULL,
            'user_id'     => self::INT_FIELD,
            'date_create' => self::TIMESTAMP_FIELD,
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_order_comment_order_id', 'order_comment', 'order_id',
            'order', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_order_comment_comment_id', 'order_comment', 'comment_id',
            'comment', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_order_comment_user_id', 'order_comment', 'user_id',
            'user', 'id', 'SET NULL', 'CASCADE');
    }

    private function _createOrderCallHistory()
    {
        $this->createTable('order_call_history', [
            'id'          => self::PRIMARY_KEY,
            'order_id'    => self::INT_FIELD_NOT_NULL,
            'user_id'     => self::INT_FIELD,
            'status'      => self::TINYINT_FIELD,
            'date_create' => self::TIMESTAMP_FIELD,
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_order_call_history_order_id', 'order_call_history', 'order_id',
            'order', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_order_call_history_user_id', 'order_call_history', 'user_id',
            'user', 'id', 'SET NULL', 'CASCADE');
    }
}
