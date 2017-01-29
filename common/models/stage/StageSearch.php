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
                    'department',
                    'name',
                    'alias',
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
            'id'         => $this->id,
            'department' => $this->department,
            'name'       => $this->name,
            'alias'      => $this->alias,
        ]);

        $query->andFilterWhere(['LIKE', 'date_create', $this->date_create]);

        return $dataProvider;
    }
}
