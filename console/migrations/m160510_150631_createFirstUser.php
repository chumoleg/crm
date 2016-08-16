<?php

use common\components\migration\Migration;
use common\components\Role;
use common\models\user\User;

class m160510_150631_createFirstUser extends Migration
{
    public function up()
    {
        $model = $this->_createNewUser();
        Role::assignRoleForUser($model, Role::ADMIN);
    }

    public function down()
    {
        $this->delete('auth_assignment', 'user_id = ' . User::ADMIN_USER);
        $this->delete('user', 'id = ' . User::ADMIN_USER);
    }

    /**
     * @return \common\models\user\User
     */
    private function _createNewUser()
    {
        $model = new User();
        $model->id = User::ADMIN_USER;
        $model->email = 'admin@admin.ru';
        $model->fio = 'Администратор';
        $model->role = Role::ADMIN;
        $model->setPassword('123456');
        $model->generateAuthKey();
        $model->date_create = date('Y-m-d H:i:s');
        $model->status = common\components\Status::STATUS_ACTIVE;

        $this->insert('user', $model->attributes);

        return User::findById(User::ADMIN_USER);
    }
}
