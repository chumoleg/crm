<?php

namespace common\models\project;

use yii\data\ActiveDataProvider;

class ProjectSearch extends Project
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
                    'label_class',
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
            'label_class' => $this->label_class,
        ]);

        $query->andFilterWhere(['LIKE', 'date_create', $this->date_create]);

        return $dataProvider;
    }
}
