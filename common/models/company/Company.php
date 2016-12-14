<?php

namespace common\models\company;

use common\components\base\ActiveRecord;
use common\models\user\User;
use common\models\order\Order;

/**
 * This is the model class for table "company".
 *
 * @property integer          $id
 * @property string           $name
 * @property string           $brand
 * @property string           $date_create
 * @property integer          $user_id
 *
 * @property User             $user
 * @property CompanyContact[] $companyContacts
 * @property Order[]          $orders
 */
class Company extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['date_create'], 'safe'],
            [['user_id'], 'integer'],
            [['name', 'brand'], 'string', 'max' => 300],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'name'        => 'Название',
            'brand'       => 'Брэнд',
            'date_create' => 'Дата создания',
            'user_id'     => 'Пользователь',
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
    public function getCompanyContacts()
    {
        return $this->hasMany(CompanyContact::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['company_id' => 'id']);
    }
}
