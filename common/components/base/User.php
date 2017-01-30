<?php

namespace common\components\base;

use Yii;
use yii\web\IdentityInterface;
use common\models\history\History;

class User extends \yii\web\User
{
    public function init()
    {
        parent::init();
//        $this->loginUrl = 'http://' . Yii::$app->params['baseUrl'] . '/site/login';
    }

    public function getWorkPlace()
    {
        return Yii::$app->session->get('workPlace');
    }

    public function login(IdentityInterface $identity, $duration = 0)
    {
        if (!parent::login($identity, $duration)) {
            return false;
        }

        History::createModel(History::TYPE_LOGIN, $this->className());

        return true;
    }

    public function logout($destroySession = true)
    {
        if (!parent::logout($destroySession)) {
            return false;
        }

        History::createModel(History::TYPE_LOGOUT, $this->className());

        return true;
    }
}