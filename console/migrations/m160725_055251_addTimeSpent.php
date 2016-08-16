<?php

use common\components\migration\Migration;

class m160725_055251_addTimeSpent extends Migration
{
    public function up()
    {
        $this->addColumn('order_progress', 'time_spent', self::INT_FIELD . ' DEFAULT 0 AFTER status');
    }

    public function down()
    {
        $this->dropColumn('order_progress', 'time_spent');
    }
}
