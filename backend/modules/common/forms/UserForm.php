<?php
namespace backend\modules\common\forms;

use common\components\Status;
use common\models\user\User;
use common\components\Role;
use common\components\helpers\ArrayHelper;
use common\models\user\UserMailSending;
use common\models\user\UserSource;
use common\models\user\UserTag;

class UserForm extends User
{
    public $tagData = [];
    public $sourceData = [];
    public $mailSendingData = [];
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
                'message' => 'Указанный email уже занят',
            ],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['password', 'string', 'min' => 6],
            [['tagData', 'sourceData', 'mailSendingData'], 'safe', 'on' => ['create', 'update']],
        ];
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(),
            [
                'password'        => 'Пароль',
                'tagData'         => 'Теги',
                'sourceData'      => 'Источники',
                'mailSendingData' => 'Рассылка',
            ]
        );
    }

    public function getPassword()
    {
        return null;
    }

    public function afterFind()
    {
        $this->_oldRole = $this->role;
        $this->tagData = $this->_getTagData();
        $this->sourceData = $this->_getSourceData();
        $this->mailSendingData = $this->_getMailSendingData();

        parent::afterFind();
    }

    public function beforeSave($insert)
    {
        if (!empty($this->password)) {
            $this->setPassword($this->password);
        }

        if ($this->isNewRecord) {
            $this->status = Status::STATUS_ACTIVE;
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
        $this->_saveSourceData();
        $this->_saveMailSendingData();

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @return array
     */
    private function _getMailSendingData()
    {
        return ArrayHelper::getColumn($this->userMailSending, 'type');
    }

    /**
     * @return array
     */
    private function _getSourceData()
    {
        return ArrayHelper::getColumn($this->userSources, 'source_id');
    }

    /**
     * @return array
     */
    private function _getTagData()
    {
        return ArrayHelper::getColumn($this->userTags, 'tag_id');
    }

    private function _saveTagData()
    {
        $oldTags = $this->_getTagData();
        if ($this->tagData == $oldTags) {
            return;
        }

        UserTag::deleteAll(['user_id' => $this->id]);
        if (empty($this->tagData)) {
            return;
        }

        foreach ($this->tagData as $tagId) {
            $model = new UserTag();
            $model->user_id = $this->id;
            $model->tag_id = $tagId;
            $model->save();
        }
    }

    private function _saveSourceData()
    {
        $oldSources = $this->_getSourceData();
        if ($this->sourceData == $oldSources) {
            return;
        }

        UserSource::deleteAll(['user_id' => $this->id]);
        if (empty($this->sourceData)) {
            return;
        }

        foreach ($this->sourceData as $sourceId) {
            $model = new UserSource();
            $model->user_id = $this->id;
            $model->source_id = $sourceId;
            $model->save();
        }
    }

    private function _saveMailSendingData()
    {
        $oldMailSendingData = $this->_getMailSendingData();
        if ($this->mailSendingData == $oldMailSendingData) {
            return;
        }

        UserMailSending::deleteAll(['user_id' => $this->id]);
        if (empty($this->mailSendingData)) {
            return;
        }

        foreach ($this->mailSendingData as $type) {
            $model = new UserMailSending();
            $model->user_id = $this->id;
            $model->type = $type;
            $model->save();
        }
    }
}
