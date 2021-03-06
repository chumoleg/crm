<?php

namespace common\models\source;

use yii\data\ActiveDataProvider;

class SourceSearch extends Source
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
                    'is_default',
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
            'name'       => $this->name,
            'is_default' => $this->is_default,
        ]);

        $query->andFilterWhere(['LIKE', 'date_create', $this->date_create]);

        return $dataProvider;
    }
}
