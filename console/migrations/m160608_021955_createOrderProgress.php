<?php

use common\components\migration\Migration;

class m160608_021955_createOrderProgress extends Migration
{
    public function up()
    {
        $this->createTable('order_progress', [
            'id'          => self::PRIMARY_KEY,
            'order_id'    => self::INT_FIELD_NOT_NULL,
            'process_id'  => self::INT_FIELD_NOT_NULL,
            'stage_id'    => self::INT_FIELD_NOT_NULL,
            'status'      => self::TINYINT_FIELD . ' DEFAULT 0',
            'user_id'     => self::INT_FIELD_NOT_NULL,
            'date_create' => self::TIMESTAMP_FIELD,
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_order_progress_order_id', 'order_progress',
            'order_id', 'order', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_order_progress_process_id', 'order_progress',
            'process_id', 'process', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_order_progress_stage_id', 'order_progress',
            'stage_id', 'stage', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('fk_order_progress_stage_id', 'order_progress');
        $this->dropForeignKey('fk_order_progress_process_id', 'order_progress');
        $this->dropForeignKey('fk_order_progress_order_id', 'order_progress');
        $this->dropTable('order_progress');
    }
}
