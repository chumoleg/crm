<?php

use common\components\migration\Migration;

class m160727_011205_createFirstStage extends Migration
{
    public function up()
    {
        $this->addColumn('process_stage', 'first_stage', self::TINYINT_FIELD . ' DEFAULT 0');
    }

    public function down()
    {
        $this->dropColumn('process_stage', 'first_stage');
    }
}
