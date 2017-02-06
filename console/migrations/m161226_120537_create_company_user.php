<?php

use console\components\migration\Migration;

class m161226_120537_create_company_user extends Migration
{
    protected $_ignoreError = true;

    public function up()
    {
        $this->addColumn('company', 'current_operator', self::INT_FIELD);

        $this->addForeignKey('fk_company_current_operator', 'company',
            'current_operator', 'user', 'id', 'SET NULL', 'CASCADE');

        $this->dropForeignKey('fk_order_current_user_id', 'order');
        $this->dropColumn('order', 'current_user_id');

        $this->dropForeignKey('fk_process_stage_operator_operator_id', 'process_stage_operator');
        $this->dropForeignKey('fk_process_stage_operator_process_id', 'process_stage_operator');
        $this->dropForeignKey('fk_process_stage_operator_stage_id', 'process_stage_operator');
        $this->dropForeignKey('fk_process_stage_operator_user_id', 'process_stage_operator');
        $this->dropTable('process_stage_operator');
    }

    public function down()
    {
        $this->dropForeignKey('fk_company_current_operator', 'company');
        $this->dropColumn('company', 'current_operator');
    }
}
