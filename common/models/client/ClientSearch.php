<?php

namespace common\models\client;

use Yii;
use yii\data\ActiveDataProvider;
use common\components\helpers\ArrayHelper;

class ClientSearch extends Client
{
    public $clientFio;
    public $clientPhone;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'id',
                    'status',
                    'user_id',
                    'date_create',
                    'clientFio',
                    'clientPhone',
                ],
                'safe'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge([
            'clientFio'   => 'ФИО клиента',
            'clientPhone' => 'Телефон',
        ], parent::attributeLabels());
    }

    /**
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = parent::find()
            ->joinWith('mainPhone')
            ->joinWith('mainPersonalData');

        $dataProvider = $this->getDataProvider($query);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'client.id'          => $this->id,
            'client.status'      => $this->status,
            'client.date_create' => $this->date_create,
            'client.user_id'     => $this->user_id
        ]);

        return $dataProvider;
    }

    /**
     * @return array
     */
    public function getUserList()
    {
        $data = self::find()->joinWith('user')->distinct('user_id')
            ->andWhere('user_id IS NOT NULL')->all();
        return ArrayHelper::map($data, 'user.id', 'user.email');
    }
}
