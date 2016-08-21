<?php

namespace warehouse\models\product;

/**
 * Class Product
 *
 * @property ProductTechList $productTechList
 */
class Product extends \common\models\product\Product
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductTechList()
    {
        return $this->hasOne(ProductTechList::className(), ['product_id' => 'id']);
    }
}
