<?php

namespace common\models\company;

use common\components\base\ActiveRecord;
use common\models\user\User;

/**
 * This is the model class for table "company_contact".
 *
 * @property integer $id
 * @property integer $company_id
 * @property string  $person
 * @property integer $type
 * @property string  $value
 * @property integer $user_id
 *
 * @property Company $company
 * @property User    $user
 */
class CompanyContact extends ActiveRecord
{
    const TYPE_PHONE = 1;
    const TYPE_EMAIL = 2;
    const TYPE_ADDRESS = 3;

    public static $typeList
        = [
            self::TYPE_PHONE   => 'Телефон',
            self::TYPE_EMAIL   => 'E-mail',
            self::TYPE_ADDRESS => 'Адрес',
        ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company_contact';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'value'], 'required'],
            [['company_id', 'type', 'user_id'], 'integer'],
            [['person', 'value'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'company_id' => 'Company ID',
            'person'     => 'Контактное лицо',
            'type'       => 'Тип контакта',
            'value'      => 'Значение',
            'user_id'    => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
