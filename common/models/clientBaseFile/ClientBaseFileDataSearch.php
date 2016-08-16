<?php

namespace common\models\clientBaseFile;

use yii\data\ActiveDataProvider;

class ClientBaseFileDataSearch extends ClientBaseFileData
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
                    'client_base_file_id',
                    'fio',
                    'phone',
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
            'id'                  => $this->id,
            'client_base_file_id' => $this->client_base_file_id,
            'fio'                 => $this->fio,
            'phone'               => $this->phone,
        ]);

        $query->andFilterWhere(['LIKE', 'date_create', $this->date_create]);

        return $dataProvider;
    }
}
