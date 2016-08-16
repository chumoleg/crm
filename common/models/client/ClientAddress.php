<?php

namespace common\models\client;

use common\components\Status;
use Yii;
use \common\components\base\ActiveRecord;
use common\models\geo\GeoAddress;
use common\models\user\User;

/**
 * This is the model class for table "client_address".
 *
 * @property integer    $id
 * @property integer    $client_id
 * @property integer    $address_id
 * @property integer    $main
 * @property integer    $user_id
 * @property string     $date_create
 *
 * @property GeoAddress $address
 * @property Client     $client
 * @property User       $user
 */
class ClientAddress extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'client_address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_id', 'address_id', 'main'], 'required'],
            [['client_id', 'address_id', 'main', 'user_id'], 'integer'],
            [['date_create'], 'safe'],
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
            'address_id'  => 'Address ID',
            'main'        => 'Main',
            'user_id'     => 'User ID',
            'date_create' => 'Date Create',
        ];
    }

    /**
     * @param int $clientId
     * @param int $addressId
     */
    public static function createNewAddress($clientId, $addressId)
    {
        $rel = new self();
        $rel->client_id = $clientId;
        $rel->address_id = $addressId;
        $rel->main = Status::STATUS_ACTIVE;
        $rel->save();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddress()
    {
        return $this->hasOne(GeoAddress::className(), ['id' => 'address_id']);
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
