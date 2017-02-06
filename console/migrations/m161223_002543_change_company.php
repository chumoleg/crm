<?php

use console\components\migration\Migration;

class m161223_002543_change_company extends Migration
{
    protected $_ignoreError = true;

    public function up()
    {
        $this->addColumn('company', 'type', 'TINYINT(1) UNSIGNED DEFAULT 1 AFTER id');

        $this->addColumn('order', 'name', 'VARCHAR(200) NOT NULL AFTER id');

        $this->addColumn('order', 'company_executor', self::INT_FIELD_NOT_NULL . ' AFTER id');
        $this->addForeignKey(
            'fk_order_company_executor',
            'order',
            'company_executor',
            'company',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        $this->dropForeignKey('fk_order_company_id', 'order');
        $this->renameColumn('order', 'company_id', 'company_customer');
        $this->addForeignKey(
            'fk_order_company_customer',
            'order',
            'company_customer',
            'company',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        $this->dropForeignKey('fk_order_create_user_id', 'order');
        $this->renameColumn('order', 'create_user_id', 'created_user_id');
        $this->addForeignKey(
            'fk_order_created_user_id',
            'order',
            'created_user_id',
            'user',
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropColumn('company', 'type');
        $this->dropColumn('order', 'name');

        $this->dropForeignKey('fk_order_created_user_id', 'order');
        $this->dropForeignKey('fk_order_company_customer', 'order');
        $this->dropForeignKey('fk_order_company_executor', 'order');
        $this->dropColumn('order', 'company_executor');
    }
}
