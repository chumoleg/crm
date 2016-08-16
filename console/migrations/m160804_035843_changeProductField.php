<?php

use common\components\migration\Migration;

class m160804_035843_changeProductField extends Migration
{
    public function up()
    {
        $this->alterColumn('product', 'article', 'VARCHAR(100) DEFAULT NULL');
    }

    public function down()
    {
    }
}
