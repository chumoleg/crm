<?php

use common\components\migration\Migration;

class m160725_011020_addStageAlias extends Migration
{
    public function up()
    {
        $this->addColumn('process_stage', 'alias', 'VARCHAR(300) NOT NULL AFTER name');
    }

    public function down()
    {
        $this->dropColumn('process_stage', 'alias');
    }
}
