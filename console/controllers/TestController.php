<?php

namespace console\controllers;

use backend\modules\common\forms\UserForm;
use common\components\Role;
use yii\console\Controller;

class TestController extends Controller
{
    public function actionCreateUser()
    {
        $form = new UserForm();
        $form->email = 'chumoleg2@yandex.ru';
        $form->fio = 'Чумаков 2';
        $form->password = '1234567890';
        $form->role = Role::OPERATOR;
        $form->save();
    }
}