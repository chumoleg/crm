<?php

namespace common\models\stage;

use yii\data\ActiveDataProvider;

class StageSearch extends Stage
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
                    'alias',
                    'call',
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
            'id'          => $this->id,
            'name'        => $this->name,
            'alias'       => $this->alias,
            'call'        => $this->call,
            'date_create' => $this->date_create
        ]);

        return $dataProvider;
    }
}
