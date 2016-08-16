<?php

use common\components\migration\Migration;

class m160727_024948_addOrderCommentManually extends Migration
{
    public function up()
    {
        $this->addColumn('order_comment', 'manually', self::TINYINT_FIELD . ' DEFAULT 0 AFTER user_id');
    }

    public function down()
    {
        $this->dropColumn('order_comment', 'manually');
    }
}
