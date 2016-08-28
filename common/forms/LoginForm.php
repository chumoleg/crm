<?php

namespace common\forms;

use Yii;
use common\components\Role;
use yii\base\Model;
use common\models\user\User;

class LoginForm extends Model
{
    public $email;
    public $password;
    public $workPlace;
    public $rememberMe = true;

    private $_user = false;

    public function attributeLabels()
    {
        return [
            'email'      => 'E-mail',
            'password'   => 'Пароль',
            'workPlace'  => '№ компьютера',
            'rememberMe' => 'Запомнить меня',
        ];
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['workPlace', 'safe'],
        ];
    }

    public function validatePassword()
    {
        if ($this->hasErrors()) {
            return;
        }

        $user = $this->getUser();
        if (empty($user)) {
            $this->addError('email', 'Указанный пользователь не зарегистрирован или заблокирован');
            return;
        }

        if (!$user->validatePassword($this->password)) {
            $this->addError('password', 'Неверный пароль');
        }
    }

    public function validateWorkPlace()
    {
        if ($this->hasErrors()) {
            return;
        }

        $user = $this->getUser();
        if (empty($user)) {
            return;
        }

        if (empty($this->workPlace) && $user->role == Role::OPERATOR) {
            $this->addError('workPlace', 'Укажите номер своего компьютера');
        }
    }

    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByEmail($this->email);
        }

        return $this->_user;
    }

    public function afterValidate()
    {
        $this->validatePassword();
        $this->validateWorkPlace();

        parent::afterValidate();
    }

    public function login()
    {
        if ($this->validate()) {
            Yii::$app->getUser()->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
            Yii::$app->session->set('workPlace', $this->workPlace);
            return true;
        }

        return false;
    }
}
