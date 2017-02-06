<?php

use console\components\migration\Migration;

class m160727_073937_addProcessStageTimeUnit extends Migration
{
    public function up()
    {
        $this->addColumn('process_stage', 'time_unit', self::TINYINT_FIELD . ' DEFAULT 1 AFTER time_limit');
    }

    public function down()
    {
        $this->dropColumn('process_stage', 'time_unit');
    }
}
