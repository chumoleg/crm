<?php

namespace common\models\product;

use common\components\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;

class ProductSearch extends Product
{
    public $tag;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'id',
                    'name',
                    'article',
                    'category',
                    'status',
                    'tag',
                    'date_create'
                ],
                'safe'
            ],
        ];
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'tag' => 'Теги'
        ]);
    }

    /**
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = parent::find();
        $dataProvider = $this->getDataProvider($query);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id'       => $this->id,
            'name'     => $this->name,
            'category' => $this->category,
            'status'   => $this->status,
        ]);

        $query->andFilterWhere(['LIKE', 'date_create', $this->date_create]);

        if (!empty($this->tag)) {
            $productTagQuery = ProductTag::find()->select(['product_id'])->andWhere(['tag_id' => $this->tag]);
            $query->andWhere(['IN', 'id', $productTagQuery]);
        }

        return $dataProvider;
    }
}
