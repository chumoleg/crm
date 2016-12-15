<?php

use common\components\migration\Migration;

class m161213_003429_create_order_company extends Migration
{
    protected $_ignoreError = true;

    public function up()
    {
        $this->createTable(
            'company',
            [
                'id'          => self::PRIMARY_KEY,
                'name'        => 'VARCHAR(200) NOT NULL',
                'brand'       => 'VARCHAR(200)',
                'date_create' => self::TIMESTAMP_FIELD,
                'user_id'     => self::INT_FIELD,
            ],
            self::TABLE_OPTIONS
        );

        $this->addForeignKey('fk_company_user_id', 'company', 'user_id', 'user', 'id', 'SET NULL', 'CASCADE');

        $this->createTable(
            'company_contact',
            [
                'id'         => self::PRIMARY_KEY,
                'company_id' => self::INT_FIELD_NOT_NULL,
                'person'     => 'VARCHAR(200) NOT NULL',
                'type'       => 'TINYINT(1) UNSIGNED NOT NULL',
                'value'      => 'VARCHAR(200) NOT NULL',
                'user_id'    => self::INT_FIELD,
            ],
            self::TABLE_OPTIONS
        );

        $this->addForeignKey(
            'fk_company_contact_company_id',
            'company_contact',
            'company_id',
            'company',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_company_contact_user_id',
            'company_contact',
            'user_id',
            'user',
            'id',
            'SET NULL',
            'CASCADE'
        );

        $this->dropForeignKey('fk_order_client_id', 'order');
        $this->dropForeignKey('fk_order_client_personal_data_id', 'order');
        $this->dropForeignKey('fk_order_client_phone_id', 'order');
        $this->dropForeignKey('fk_order_address_id', 'order');
        $this->dropColumn('order', 'client_phone_id');
        $this->dropColumn('order', 'client_id');
        $this->dropColumn('order', 'client_personal_data_id');
        $this->dropColumn('order', 'delivery_price');
        $this->dropColumn('order', 'type_delivery');
        $this->dropColumn('order', 'sending_tracker');
        $this->dropColumn('order', 'address_id');

        $this->addColumn('order', 'company_id', self::INT_FIELD_NOT_NULL. ' AFTER id');
        $this->addForeignKey('fk_order_company_id', 'order', 'company_id', 'company', 'id', 'CASCADE', 'CASCADE');

        $this->dropColumn('process', 'type');

        $this->dropForeignKey('fk_client_personal_data_client_id', 'client_personal_data');
        $this->dropForeignKey('fk_client_personal_data_user_id', 'client_personal_data');
        $this->dropTable('client_personal_data');

        $this->dropForeignKey('fk_client_address_address_id', 'client_address');
        $this->dropForeignKey('fk_client_address_client_id', 'client_address');
        $this->dropForeignKey('fk_client_address_user_id', 'client_address');
        $this->dropTable('client_address');

        $this->dropForeignKey('fk_client_phone_client_id', 'client_phone');
        $this->dropForeignKey('fk_client_phone_user_id', 'client_phone');
        $this->dropTable('client_phone');

        $this->dropForeignKey('fk_client_user_id', 'client');
        $this->dropTable('client');

        $this->dropForeignKey('fk_client_base_file_data_client_base_file_id', 'client_base_file_data');
        $this->dropTable('client_base_file_data');

        $this->dropTable('client_base_file');
    }

    public function down()
    {
        $this->dropForeignKey('fk_order_company_id', 'order');
        $this->dropColumn('order', 'company_id');

        $this->dropForeignKey('fk_company_contact_user_id', 'company_contact');
        $this->dropForeignKey('fk_company_contact_company_id', 'company_contact');
        $this->dropTable('company_contact');

        $this->dropForeignKey('fk_company_user_id', 'company');
        $this->dropTable('company');
    }
}
