<?php

namespace common\models\product;

use common\components\base\ActiveRecord;
use common\models\tag\Tag;

/**
 * This is the model class for table "product_tag".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $tag_id
 * @property string  $date_create
 *
 * @property Product $product
 * @property Tag     $tag
 */
class ProductTag extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'tag_id'], 'required'],
            [['product_id', 'tag_id'], 'integer'],
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
            'product_id'  => 'Product ID',
            'tag_id'      => 'Tag ID',
            'date_create' => 'Date Create',
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
    public function getTag()
    {
        return $this->hasOne(Tag::className(), ['id' => 'tag_id']);
    }
}
