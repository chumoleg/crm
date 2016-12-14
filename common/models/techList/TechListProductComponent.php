<?php

namespace common\models\techList;

use common\components\base\ActiveRecord;
use common\models\productComponent\ProductComponent;

/**
 * This is the model class for table "wh_tech_list_product_component".
 *
 * @property integer          $id
 * @property integer          $tech_list_id
 * @property integer          $product_component_id
 * @property integer          $quantity
 * @property string           $date_create
 *
 * @property ProductComponent $productComponent
 * @property TechList         $techList
 */
class TechListProductComponent extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wh_tech_list_product_component';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_component_id', 'quantity'], 'required'],
            [['tech_list_id', 'product_component_id', 'quantity'], 'integer'],
            [['date_create'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                   => 'ID',
            'tech_list_id'         => 'Тех.лист',
            'product_component_id' => 'Комплектующая',
            'quantity'             => 'Кол-во',
            'date_create'          => 'Дата создания',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductComponent()
    {
        return $this->hasOne(ProductComponent::className(), ['id' => 'product_component_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTechList()
    {
        return $this->hasOne(TechList::className(), ['id' => 'tech_list_id']);
    }
}
