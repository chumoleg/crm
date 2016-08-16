<?php
namespace backend\modules\common\forms;

use common\models\user\User;
use common\components\Role;
use common\components\helpers\ArrayHelper;
use common\models\user\UserTag;

class UserForm extends User
{
    public $tagData = [];
    public $password;
    private $_oldRole;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'password', 'role', 'fio'], 'filter', 'filter' => 'trim'],
            [['email', 'role'], 'required'],
            [['password'], 'required', 'on' => 'create'],
            [
                'email',
                'unique',
                'message' => 'Указанный email уже занят'
            ],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['password', 'string', 'min' => 6],
            [['tagData'], 'safe', 'on' => ['create', 'update']]
        ];
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'password' => 'Пароль',
            'tagData'  => 'Теги (для подгрузки заказов)'
        ]);
    }

    public function getPassword()
    {
        return null;
    }

    public function afterFind()
    {
        $this->_oldRole = $this->role;
        $this->tagData = ArrayHelper::getColumn($this->userTags, 'tag_id');

        parent::afterFind();
    }

    public function beforeSave($insert)
    {
        if (!empty($this->password)) {
            $this->setPassword($this->password);
        }

        $this->generateAuthKey();

        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($this->isNewRecord) {
            Role::assignRoleForUser($this, $this->role);

        } elseif ($this->role != $this->_oldRole) {
            Role::revokeRoleForUser($this, $this->_oldRole);
            Role::assignRoleForUser($this, $this->role);
        }

        $this->_saveTagData();

        parent::afterSave($insert, $changedAttributes);
    }

    private function _saveTagData()
    {
        UserTag::deleteAll(['user_id' => $this->id]);
        if (empty($this->tagData)) {
            return;
        }

        foreach ($this->tagData as $item) {
            $model = new UserTag();
            $model->user_id = $this->id;
            $model->tag_id = $item;
            $model->save();
        }
    }
}
