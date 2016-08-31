<?php

namespace warehouse\models\transaction;

use yii\data\ActiveDataProvider;

class TransactionSearch extends Transaction
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
                    'type',
                    'date_create'
                ],
                'safe'
            ],
        ];
    }

    /**
     * @param array         $params
     * @param callable|null $filter
     *
     * @return ActiveDataProvider
     */
    public function search($params, callable $filter = null)
    {
        $query = parent::find();
        if (is_callable($filter)) {
            call_user_func($filter, $query);
        }

        $dataProvider = $this->getDataProvider($query);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id'          => $this->id,
            'name'        => $this->name,
            'type'        => $this->type,
            'date_create' => $this->date_create
        ]);

        return $dataProvider;
    }
}
