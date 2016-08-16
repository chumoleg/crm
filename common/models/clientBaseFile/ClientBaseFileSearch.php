<?php

namespace common\models\clientBaseFile;

use yii\data\ActiveDataProvider;

class ClientBaseFileSearch extends ClientBaseFile
{
    public $countRows;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'id',
                    'client_name',
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

        $query->select([
            'id',
            'client_name',
            'date_create',
            '(SELECT COUNT(id) FROM client_base_file_data WHERE client_base_file_id = client_base_file.id) AS countRows'
        ]);

        $query->andFilterWhere([
            'id'          => $this->id,
            'client_name' => $this->client_name
        ]);

        $query->andFilterWhere(['LIKE', 'date_create', $this->date_create]);

        return $dataProvider;
    }
}
