<?php

namespace common\models\product;

use common\components\base\ActiveRecord;
use common\models\techList\TechList;

/**
 * This is the model class for table "wh_product_tech_list".
 *
 * @property integer  $id
 * @property integer  $product_id
 * @property integer  $tech_list_id
 * @property integer  $priority
 * @property string   $date_create
 *
 * @property Product  $product
 * @property TechList $techList
 */
class ProductTechList extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wh_product_tech_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'tech_list_id'], 'required'],
            [['product_id', 'tech_list_id', 'priority'], 'integer'],
            [['date_create'], 'safe'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'           => 'ID',
            'product_id'   => 'Product ID',
            'tech_list_id' => 'Tech List ID',
            'priority'     => 'Priority',
            'date_create'  => 'Date Create',
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
    public function getTechList()
    {
        return $this->hasOne(TechList::className(), ['id' => 'tech_list_id']);
    }
}
