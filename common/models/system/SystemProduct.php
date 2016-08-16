<?php

namespace common\models\system;

use common\components\base\ActiveRecord;
use common\models\product\Product;

/**
 * This is the model class for table "system_product".
 *
 * @property integer $id
 * @property integer $system_id
 * @property integer $product_id
 * @property string  $foreign_number
 * @property string  $date_create
 *
 * @property Product $product
 * @property System  $system
 */
class SystemProduct extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'system_product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['system_id', 'product_id', 'foreign_number'], 'required'],
            [['system_id', 'product_id'], 'integer'],
            [['date_create'], 'safe'],
            [['foreign_number'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'             => 'ID',
            'system_id'      => 'System ID',
            'product_id'     => 'Product ID',
            'foreign_number' => 'Foreign Number',
            'date_create'    => 'Date Create',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSystem()
    {
        return $this->hasOne(System::className(), ['id' => 'system_id']);
    }
}
