<?php

namespace warehouse\models\productComponent;

use common\components\base\ActiveRecord;
use warehouse\models\techList\TechListProductComponent;
use warehouse\models\transaction\TransactionProductComponent;

/**
 * This is the model class for table "wh_product_component".
 *
 * @property integer                       $id
 * @property string                        $name
 * @property string                        $date_create
 *
 * @property TechListProductComponent[]    $techListProductComponents
 * @property TransactionProductComponent[] $transactionProductComponents
 */
class ProductComponent extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wh_product_component';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
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
            'name'        => 'Название',
            'date_create' => 'Дата создания',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTechListProductComponents()
    {
        return $this->hasMany(TechListProductComponent::className(), ['product_component_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransactionProductComponents()
    {
        return $this->hasMany(TransactionProductComponent::className(), ['product_component_id' => 'id']);
    }
}
