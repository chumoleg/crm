<?php

use console\components\migration\Migration;

class m160725_091200_changeOrderStage extends Migration
{
    public function up()
    {
        $this->addColumn('order_stage', 'time_limit', self::INT_FIELD . ' DEFAULT 0 AFTER status');
        $this->addColumn('order_stage', 'overdue', self::TINYINT_FIELD . ' DEFAULT 0 AFTER status');
    }

    public function down()
    {
        $this->dropColumn('order_stage', 'time_limit');
        $this->dropColumn('order_stage', 'overdue');
    }
}
