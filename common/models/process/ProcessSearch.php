<?php

namespace common\models\process;

use Yii;
use yii\data\ActiveDataProvider;

class ProcessSearch extends Process
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
                    'type',
                    'name',
                    'status',
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
            'type'        => $this->type,
            'name'        => $this->name,
            'status'      => $this->status,
            'date_create' => $this->date_create
        ]);

        return $dataProvider;
    }
}
