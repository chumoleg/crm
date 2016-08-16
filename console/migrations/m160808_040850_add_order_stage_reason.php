<?php

use common\components\migration\Migration;

class m160808_040850_add_order_stage_reason extends Migration
{
    public function up()
    {
        $this->addColumn('stage', 'call', self::TINYINT_FIELD . ' AFTER alias');

        $this->addColumn('order_stage', 'action_id', self::INT_FIELD . ' DEFAULT NULL AFTER stage_id');
        $this->addColumn('order_stage', 'reason_id', self::INT_FIELD . ' DEFAULT NULL AFTER action_id');

        $this->addForeignKey('fk_order_stage_action_id', 'order_stage', 'action_id',
            'action', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('fk_order_stage_reason_id', 'order_stage', 'reason_id',
            'reason', 'id', 'SET NULL', 'CASCADE');
    }

    public function down()
    {
        $this->dropColumn('stage', 'call');

        $this->dropForeignKey('fk_order_stage_action_id', 'order_stage');
        $this->dropColumn('order_stage', 'action_id');

        $this->dropForeignKey('fk_order_stage_reason_id', 'order_stage');
        $this->dropColumn('order_stage', 'reason_id');
    }
}
