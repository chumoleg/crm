<?php

namespace common\models\productComponent;

use common\components\base\ActiveRecord;

/**
 * This is the model class for table "wh_product_component_stock".
 *
 * @property integer          $id
 * @property integer          $product_component_id
 * @property integer          $quantity
 * @property integer          $status
 * @property string           $date_create
 * @property string           $date_update
 *
 * @property ProductComponent $productComponent
 */
class ProductComponentStock extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wh_product_component_stock';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_component_id', 'quantity'], 'required'],
            [['product_component_id', 'quantity', 'status'], 'integer'],
            [['date_create', 'date_update'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                   => 'ID',
            'product_component_id' => 'ID комплектующей',
            'quantity'             => 'Количество',
            'status'               => 'Статус',
            'date_create'          => 'Дата создания',
            'date_update'          => 'Дата изменения',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductComponent()
    {
        return $this->hasOne(ProductComponent::className(), ['id' => 'product_component_id']);
    }
}
