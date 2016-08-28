<?php

use common\components\migration\Migration;

class m160828_045633_add_order_sending_tracker extends Migration
{
    public function up()
    {
        $this->addColumn('order', 'sending_tracker', 'VARCHAR(50) DEFAULT NULL AFTER type_delivery');
    }

    public function down()
    {
        $this->dropColumn('order', 'sending_tracker');
    }
}
