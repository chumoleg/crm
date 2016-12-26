<?php

use common\components\migration\Migration;

class m161226_161633_change_quantity_field extends Migration
{
    public function up()
    {
        $this->alterColumn('order_product', 'quantity', self::INT_FIELD_NOT_NULL);
    }

    public function down()
    {
    }
}
