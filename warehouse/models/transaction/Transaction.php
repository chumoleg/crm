<?php

namespace warehouse\models\transaction;

use common\components\base\ActiveRecord;

/**
 * This is the model class for table "wh_transaction".
 *
 * @property integer                       $id
 * @property integer                       $type
 * @property string                        $name
 * @property string                        $date_create
 *
 * @property TransactionProductComponent[] $transactionProductComponents
 */
class Transaction extends ActiveRecord
{
    const TYPE_INCOME = 1;
    const TYPE_WRITTEN = 2;

    public static $typeList
        = [
            self::TYPE_INCOME  => 'Поступление',
            self::TYPE_WRITTEN => 'Списание',
        ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wh_transaction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'name'], 'required'],
            [['type'], 'integer'],
            [['date_create'], 'safe'],
            [['name'], 'string', 'max' => 300]
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
            'date_create' => 'Дата создания',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransactionProductComponents()
    {
        return $this->hasMany(TransactionProductComponent::className(), ['transaction_id' => 'id']);
    }
}
