<?php

namespace common\models\client;

use common\components\Status;
use Yii;
use \common\components\base\ActiveRecord;
use common\models\user\User;

/**
 * This is the model class for table "client_personal_data".
 *
 * @property integer $id
 * @property integer $client_id
 * @property string  $fio
 * @property integer $main
 * @property integer $user_id
 * @property string  $date_create
 *
 * @property Client  $client
 * @property User    $user
 */
class ClientPersonalData extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'client_personal_data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_id', 'fio', 'main'], 'required'],
            [['client_id', 'main', 'user_id'], 'integer'],
            [['date_create'], 'safe'],
            [['fio'], 'string', 'max' => 300],
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
            'fio'         => 'Fio',
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

    /**
     * @param $clientId
     * @param $fio
     */
    public static function createNew($clientId, $fio)
    {
        $rel = new ClientPersonalData();
        $rel->client_id = $clientId;
        $rel->fio = $fio;
        $rel->main = Status::STATUS_ACTIVE;
        $rel->save();
    }
}
