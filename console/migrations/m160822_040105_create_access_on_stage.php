<?php

use common\components\migration\Migration;

class m160822_040105_create_access_on_stage extends Migration
{
    public function up()
    {
        try {
            $this->dropColumn('stage', 'call');
        } catch (\Exception $e) {
        }

        $this->createTable('stage_method', [
            'id'          => self::PRIMARY_KEY,
            'stage_id'    => self::INT_FIELD_NOT_NULL,
            'method'      => 'TINYINT UNSIGNED NOT NULL',
            'date_create' => self::TIMESTAMP_FIELD
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_stage_method_stage_id', 'stage_method', 'stage_id',
            'stage', 'id', 'CASCADE', 'CASCADE');

        $this->addColumn('stage', 'department', self::INT_FIELD_NOT_NULL);
        $this->execute('UPDATE stage SET department = 1');
    }

    public function down()
    {
        $this->dropColumn('stage', 'department');

        $this->dropForeignKey('fk_stage_method_stage_id', 'stage_method');
        $this->dropTable('stage_method');
    }
}
