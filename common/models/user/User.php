<?php

namespace common\models\user;

use common\components\Role;
use common\components\Status;
use Yii;
use \common\components\base\ActiveRecord;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;
use common\components\helpers\ArrayHelper;

/**
 * This is the model class for table "user".
 *
 * @property integer       $id
 * @property string        $email
 * @property string        $fio
 * @property string        $role
 * @property string        $password_hash
 * @property string        $password_reset_token
 * @property string        $auth_key
 * @property integer       $status
 * @property string        $date_create
 *
 * @property UserHistory[] $userHistories
 * @property UserTag[]     $userTags
 */
class User extends ActiveRecord implements IdentityInterface
{
    const ADMIN_USER = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'auth_key'], 'required'],
            [['status'], 'integer'],
            [['role'], 'string', 'max' => 50],
            [['fio'], 'string', 'max' => 200],
            [['email'], 'string', 'max' => 64],
            [['password_hash'], 'string', 'max' => 60],
            [['password_reset_token'], 'string', 'max' => 44],
            [['auth_key'], 'string', 'max' => 32],
            [['date_create'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                   => 'ID',
            'email'                => 'Email',
            'fio'                  => 'ФИО',
            'role'                 => 'Роль',
            'password_hash'        => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'auth_key'             => 'Auth Key',
            'status'               => 'Статус',
            'date_create'          => 'Дата создания',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserHistories()
    {
        return $this->hasMany(UserHistory::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserTags()
    {
        return $this->hasMany(UserTag::className(), ['user_id' => 'id']);
    }

    /**
     * Finds user by email
     *
     * @param string $email
     *
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return self::find()
            ->andWhere(['email' => $email])
            ->andWhere(['status' => Status::STATUS_ACTIVE])
            ->one();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     *
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return self::find()->andWhere(['id' => $id])->one();
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * @param $role
     *
     * @return array
     */
    public static function getListByRole($role)
    {
        $userIds = Yii::$app->authManager->getUserIdsByRole($role);
        if (empty($userIds)) {
            return [];
        }

        $data = self::find()->andWhere(['id' => $userIds])->all();

        return ArrayHelper::map($data, 'id', 'fio');
    }

    public static function isOperator()
    {
        return Yii::$app->user->can(Role::OPERATOR);
    }

    public static function isAdmin()
    {
        return Yii::$app->user->can(Role::ADMIN);
    }

}
