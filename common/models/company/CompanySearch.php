<?php

namespace common\models\company;

use Yii;
use yii\data\ActiveDataProvider;

class CompanySearch extends Company
{
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
                    'brand',
                    'type',
                    'current_operator',
                ],
                'safe',
            ],
        ];
    }

    /**
     * @param array $params
     * @param array $defaultOrder
     *
     * @return ActiveDataProvider
     */
    public function search($params, $defaultOrder = [])
    {
        $query = parent::find();

        $dataProvider = $this->getDataProvider($query, $defaultOrder);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(
            [
                'id'   => $this->id,
                'type' => $this->type,
                'current_operator' => $this->current_operator,
            ]
        );

        $query->andFilterWhere(['LIKE', 'name', $this->name]);
        $query->andFilterWhere(['LIKE', 'brand', $this->brand]);

        return $dataProvider;
    }
}
