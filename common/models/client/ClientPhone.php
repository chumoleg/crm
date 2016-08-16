<?php

namespace common\models\client;

use Yii;
use \common\components\base\ActiveRecord;
use common\models\user\User;
use common\components\Status;

/**
 * This is the model class for table "client_phone".
 *
 * @property integer $id
 * @property integer $client_id
 * @property string  $phone
 * @property integer $main
 * @property integer $user_id
 * @property string  $date_create
 *
 * @property Client  $client
 * @property User    $user
 */
class ClientPhone extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'client_phone';
    }

    /**
     * @param string $phone
     *
     * @return null|ClientPhone
     */
    public static function getModelByPhone($phone)
    {
        return self::find()
            ->andWhere(['phone' => $phone])
            ->one();
    }

    /**
     * @param $clientId
     * @param $phone
     */
    public static function createNew($clientId, $phone)
    {
        $rel = new self();
        $rel->client_id = $clientId;
        $rel->phone = $phone;
        $rel->main = Status::STATUS_ACTIVE;
        $rel->save();

        $oldPhones = self::find()
            ->andWhere(['client_id' => $clientId])
            ->andWhere(['main' => Status::STATUS_ACTIVE])
            ->andWhere(['!=', 'id', $rel->id])
            ->all();

        foreach ($oldPhones as $oldRel) {
            $oldRel->main = Status::STATUS_NOT_ACTIVE;
            $oldRel->save();
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_id', 'phone', 'main'], 'required'],
            [['client_id', 'main', 'user_id'], 'integer'],
            [['date_create'], 'safe'],
            [['phone'], 'string', 'max' => 300],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'client_id'   => 'Client ID',
            'phone'       => 'Phone',
            'main'        => 'Main',
            'user_id'     => 'User ID',
            'date_create' => 'Date Create',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Client::className(), ['id' => 'client_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
