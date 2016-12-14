<?php

namespace common\models\productComponent;

use common\components\Status;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class ProductComponentStockSearch extends ProductComponentStock
{
    public $productComponentName;

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'productComponentName' => 'Название комплектующей'
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'product_component_id',
                    'productComponentName',
                    'quantity',
                    'date_update',
                    'date_create'
                ],
                'safe'
            ],
        ];
    }

    /**
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = parent::find()
            ->andWhere(['status' => Status::STATUS_ACTIVE])
            ->joinWith('productComponent');

        $dataProvider = $this->getDataProvider($query, ['quantity' => SORT_ASC]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'product_component_id'   => $this->product_component_id,
            'quantity'               => $this->quantity,
            'date_update'            => $this->date_update,
            'date_create'            => $this->date_create,
            'product_component.name' => $this->productComponentName
        ]);

        return $dataProvider;
    }
}
