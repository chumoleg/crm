<?php

use common\components\migration\Migration;

class m160623_012758_changeFieldCity extends Migration
{
    public function up()
    {
        try {
            $this->dropForeignKey('fk_geo_city_area_id', 'geo_city');
            $this->dropForeignKey('fk_geo_address_city_id', 'geo_address');
            $this->dropTable('geo_city');

            $this->renameColumn('geo_address', 'city_id', 'city');
            $this->alterColumn('geo_address', 'city', 'VARCHAR(100) DEFAULT NULL');

        } catch (\Exception $e){
        }
    }

    public function down()
    {
    }
}
