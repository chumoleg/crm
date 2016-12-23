<?php

namespace common\models\company;

use common\components\base\ActiveRecord;
use common\components\helpers\ArrayHelper;
use common\models\user\User;
use common\models\order\Order;

/**
 * This is the model class for table "company".
 *
 * @property integer          $id
 * @property integer          $type
 * @property string           $name
 * @property string           $brand
 * @property string           $date_create
 * @property integer          $user_id
 *
 * @property User             $user
 * @property CompanyContact[] $companyContacts
 */
class Company extends ActiveRecord
{
    const TYPE_CUSTOMER = 1;
    const TYPE_EXECUTOR = 2;

    public static $typeList
        = [
            self::TYPE_CUSTOMER => 'Клиент',
            self::TYPE_EXECUTOR => 'Исполнитель',
        ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company';
    }

    /**
     * @param int $type
     *
     * @return array
     */
    public static function getListByType($type)
    {
        $data = self::find()->andWhere(['type' => $type])->all();

        return ArrayHelper::map($data, 'id', 'name');
    }

    public static function getListCustomers()
    {
        return self::getListByType(self::TYPE_CUSTOMER);
    }

    public static function getListExecutors()
    {
        return self::getListByType(self::TYPE_EXECUTOR);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            [['user_id', 'type'], 'integer'],
            [['name', 'brand'], 'string', 'max' => 300],
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

    public function getName()
    {
        return $this->name;
    }
}
