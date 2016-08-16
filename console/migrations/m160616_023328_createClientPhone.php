<?php

use common\components\migration\Migration;

class m160616_023328_createClientPhone extends Migration
{
    public function up()
    {
        try {
            $this->dropForeignKey('fk_client_contact_client_id', 'client_contact');
            $this->dropForeignKey('fk_client_contact_user_id', 'client_contact');

            $this->renameTable('client_contact', 'client_phone');

            $this->addForeignKey('fk_client_phone_user_id', 'client_phone', 'user_id',
                'user', 'id', 'SET NULL', 'CASCADE');
            $this->addForeignKey('fk_client_phone_client_id', 'client_phone', 'client_id',
                'client', 'id', 'CASCADE', 'CASCADE');

        } catch (\Exception $e) {
        }

        try {
            $this->dropColumn('client_phone', 'type');
            $this->renameColumn('client_phone', 'value', 'phone');
        } catch (\Exception $e) {
        }

        $this->addColumn('order', 'client_phone_id', self::INT_FIELD_NOT_NULL . ' AFTER client_id');
        $this->addColumn('order', 'client_personal_data_id', self::INT_FIELD . ' AFTER client_phone_id');

        $this->addForeignKey('fk_order_client_phone_id', 'order', 'client_phone_id',
            'client_phone', 'id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey('fk_order_client_personal_data_id', 'order', 'client_personal_data_id',
            'client_personal_data', 'id', 'SET NULL', 'CASCADE');

        try {
            $this->dropForeignKey('fk_geo_address_region_id', 'geo_address');
            $this->dropColumn('geo_address', 'region_id');

        } catch (\Exception $e) {
        }

        try {
            $this->dropForeignKey('fk_geo_city_region_id', 'geo_city');
            $this->dropColumn('geo_city', 'region_id');

        } catch (\Exception $e) {
        }
    }

    public function down()
    {
        $this->dropForeignKey('fk_order_client_phone_id', 'order');
        $this->dropForeignKey('fk_order_client_personal_data_id', 'order');
        $this->dropColumn('order', 'client_personal_data_id');
        $this->dropColumn('order', 'client_phone_id');
    }
}
