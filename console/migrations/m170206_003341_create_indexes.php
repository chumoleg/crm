<?php

use common\components\migration\Migration;

class m170206_003341_create_indexes extends Migration
{
    public function up()
    {
        $this->createIndex('index_alias', 'stage', 'alias');
        $this->createIndex('index_time_postponed', 'order', 'time_postponed');
    }

    public function down()
    {
        $this->dropIndex('index_alias', 'stage');
        $this->dropIndex('index_time_postponed', 'order');
    }
}
