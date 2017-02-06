<?php

use console\components\migration\Migration;

class m170129_042810_create_default_source extends Migration
{
    public function up()
    {
        $this->addColumn('source', 'is_default', 'TINYINT(1) UNSIGNED DEFAULT 0 AFTER name');
    }

    public function down()
    {
        $this->dropColumn('source', 'is_default');
    }
}
