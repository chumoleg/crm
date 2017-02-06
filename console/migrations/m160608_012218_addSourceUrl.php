<?php

use console\components\migration\Migration;

class m160608_012218_addSourceUrl extends Migration
{
    public function up()
    {
        $this->addColumn('source', 'url', 'VARCHAR(200) DEFAULT NULL AFTER name');
    }

    public function down()
    {
        $this->dropColumn('source', 'url');
    }
}
