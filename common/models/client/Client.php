<?php

namespace common\models\client;

use common\components\helpers\ArrayHelper;
use common\components\Status;
use common\models\geo\GeoAddress;
use common\components\base\ActiveRecord;
use common\models\order\Order;
use common\models\user\User;

/**
 * This is the model class for table "client".
 *
 * @property integer              $id
 * @property integer              $type
 * @property integer              $is_new
 * @property integer              $status
 * @property integer              $user_id
 * @property string               $date_create
 *
 * @property User                 $user
 * @property ClientAddress[]      $clientAddresses
 * @property ClientPhone[]        $clientPhones
 * @property ClientPersonalData[] $clientPersonalDatas
 * @property ClientPersonalData   $mainPersonalData
 * @property ClientAddress        $mainAddress
 * @property ClientPhone          $mainPhone
 * @property Order[]              $orders
 */
class Client extends ActiveRecord
{
    const STATUS_HAS_NEW_ORDER = 1;
    const STATUS_NOT_ANSWER = 2;
    const STATUS_HAS_RETURN = 3;
    const STATUS_CANCELED_ORDER = 4;
    const STATUS_HOLD = 5;
    const STATUS_BAN = 6;

    const TYPE_PERSONAL = 1;
    const TYPE_COMPANY = 2;

    public static $statusList
        = [
            self::STATUS_HAS_NEW_ORDER  => 'Оформлен заказ',
            self::STATUS_NOT_ANSWER     => 'Не отвечает',
            self::STATUS_HAS_RETURN     => 'Возврат',
            self::STATUS_CANCELED_ORDER => 'Отказ от заказа',
            self::STATUS_HOLD           => 'Звонок отложен',
            self::STATUS_BAN            => 'Заблокирован',
        ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'client';
    }

    /**
     * @param bool $isNew
     * @param bool $getCount
     *
     * @return Client[]|int
     */
    public static function getClientsList($isNew = false, $getCount = false)
    {
        $query = self::find()->joinWith(['mainPersonalData', 'mainAddress.address']);
        if ($isNew) {
            $query->andWhere(['is_new' => Status::STATUS_ACTIVE]);
        }

        if ($getCount) {
            return $query->count();
        }

        return $query->all();
    }

    public static function getCountClients($isNew = false)
    {
        return self::getClientsList($isNew, true);
    }

    /**
     * @return int|string
     */
    public static function getOverdueClients()
    {
        $query = self::find()
            ->andWhere('id IN (SELECT o.client_id FROM order_stage os LEFT JOIN `order` o ON o.id= os.order_id 
                WHERE os.status = 1 AND os.overdue = 1)');

        return $query->count();
    }

    /**
     * @param string $phone
     * @param string $fio
     * @param array  $addressData
     *
     * @return Client|null
     */
    public static function getModel($phone, $fio, $addressData)
    {
        if (empty($phone)) {
            return null;
        }

        $transaction = self::getDb()->beginTransaction();
        try {
            $relModel = ClientPhone::getModelByPhone($phone);
            if (!empty($relModel)) {
                $transaction->commit();

                return self::findById($relModel->client_id);
            }

            $clientId = self::_createNewModel();
            if (empty($clientId)) {
                $transaction->rollBack();

                return null;
            }

            ClientPhone::createNew($clientId, $phone);
            ClientPersonalData::createNew($clientId, $fio);

            self::createNewAddress($clientId, $addressData);

            $transaction->commit();

            return self::findById($clientId);

        } catch (\Exception $e) {
            $transaction->rollBack();

            return null;
        }
    }

    /**
     * @return int
     */
    private static function _createNewModel()
    {
        $model = new self();
        $model->type = self::TYPE_PERSONAL;
        $model->status = self::STATUS_HAS_NEW_ORDER;
        $model->is_new = Status::STATUS_ACTIVE;
        $model->save();

        return $model->id;
    }

    public static function createNewAddress($clientId, $addressData)
    {
        $addressModel = GeoAddress::getByAttributes($addressData);
        if (!empty($addressModel)) {
            ClientAddress::createNewAddress($clientId, $addressModel->id);
            return $addressModel;
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'status'], 'required'],
            [['type', 'is_new', 'status', 'user_id'], 'integer'],
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
            'type'        => 'Тип',
            'is_new'      => 'Новый клиент',
            'status'      => 'Статус',
            'user_id'     => 'Создан',
            'date_create' => 'Дата создания',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientAddresses()
    {
        return $this->hasMany(ClientAddress::className(), ['client_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientPhones()
    {
        return $this->hasMany(ClientPhone::className(), ['client_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientPersonalDatas()
    {
        return $this->hasMany(ClientPersonalData::className(), ['client_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMainPersonalData()
    {
        return $this->hasOne(ClientPersonalData::className(), ['client_id' => 'id'])
            ->andOnCondition(['client_personal_data.main' => Status::STATUS_ACTIVE]);
    }

    public function getFio()
    {
        return ArrayHelper::getValue($this, 'mainPersonalData.fio');
    }

    public function getPhone()
    {
        return ArrayHelper::getValue($this, 'mainPhone.phone');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMainAddress()
    {
        return $this->hasOne(ClientAddress::className(), ['client_id' => 'id'])
            ->andOnCondition(['client_address.main' => Status::STATUS_ACTIVE]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMainPhone()
    {
        return $this->hasOne(ClientPhone::className(), ['client_id' => 'id'])
            ->andOnCondition(['client_phone.main' => Status::STATUS_ACTIVE]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['client_id' => 'id']);
    }

    /**
     * @return null|string
     */
    public function getAddress()
    {
        if (empty($this->mainAddress)) {
            return null;
        }

        return $this->mainAddress->address;
    }

    /**
     * @return bool
     */
    public function setIsNotNew()
    {
        $this->is_new = Status::STATUS_NOT_ACTIVE;

        return $this->save();
    }
}
