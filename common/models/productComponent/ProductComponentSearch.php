<?php

namespace common\models\productComponent;

use yii\data\ActiveDataProvider;

class ProductComponentSearch extends ProductComponent
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
        $query = parent::find();
        $dataProvider = $this->getDataProvider($query);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id'   => $this->id,
            'name' => $this->name,
        ]);

        $query->andFilterWhere(['LIKE', 'date_create', $this->date_create]);

        return $dataProvider;
    }
}
