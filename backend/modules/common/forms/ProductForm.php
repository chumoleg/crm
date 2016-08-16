<?php

namespace backend\modules\management\modules\common\forms;

use common\models\product\Product;
use common\components\Status;
use common\components\helpers\ArrayHelper;
use common\models\product\ProductPrice;
use common\models\product\ProductTag;

class ProductForm extends Product
{
    public $priceData = [];
    public $tagData = [];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge([
            [['tagData'], 'required'],
            [['priceData'], 'safe'],
        ], parent::rules());
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'tagData'   => 'Теги товара',
            'priceData' => 'Цены товара'
        ]);
    }

    public function beforeSave($insert)
    {
        $this->status = Status::STATUS_ACTIVE;

        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        $this->_savePriceData();
        $this->_saveTagData();

        parent::afterSave($insert, $changedAttributes);
    }

    public function afterFind()
    {
        parent::afterFind();

        $this->tagData = ArrayHelper::getColumn($this->productTags, 'tag_id');
    }

    private function _savePriceData()
    {
        ProductPrice::deleteAll(['product_id' => $this->id]);
        if (empty($this->priceData)) {
            return;
        }

        foreach ($this->priceData as $item) {
            $model = new ProductPrice();
            $model->attributes = $item;
            $model->product_id = $this->id;
            $model->status = Status::STATUS_ACTIVE;
            $model->save();
        }
    }

    private function _saveTagData()
    {
        ProductTag::deleteAll(['product_id' => $this->id]);
        if (empty($this->tagData)) {
            return;
        }

        foreach ($this->tagData as $item) {
            $model = new ProductTag();
            $model->product_id = $this->id;
            $model->tag_id = $item;
            $model->save();
        }
    }
}
