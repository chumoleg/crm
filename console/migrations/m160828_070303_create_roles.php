<?php

use common\components\migration\Migration;
use common\components\Role;

class m160828_070303_create_roles extends Migration
{
    public function up()
    {
        try {
            $auth = Yii::$app->authManager;

            $operator = $auth->createRole(Role::WAREHOUSE_MANAGER);
            $auth->add($operator);
        } catch (\Exception $e){
        }
    }

    public function down()
    {
    }
}
