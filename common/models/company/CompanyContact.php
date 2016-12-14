<?php

namespace common\models\company;

use common\components\base\ActiveRecord;
use common\models\user\User;

/**
 * This is the model class for table "company_contact".
 *
 * @property integer $id
 * @property integer $company_id
 * @property integer $type
 * @property string  $value
 * @property integer $user_id
 *
 * @property Company $company
 * @property User    $user
 */
class CompanyContact extends ActiveRecord
{
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
            [['company_id', 'type', 'value'], 'required'],
            [['company_id', 'type', 'user_id'], 'integer'],
            [['value'], 'string', 'max' => 200],
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
            'type'       => 'Type',
            'value'      => 'Value',
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
