<?php

namespace common\models\user;

use common\components\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;

class UserSearch extends User
{
    public $tag;
    public $source;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'id',
                    'email',
                    'fio',
                    'role',
                    'fio',
                    'tag',
                    'source',
                    'date_create'
                ],
                'safe'
            ],
        ];
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'tag'    => 'Теги',
            'source' => 'Источники'
        ]);
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
            'id'     => $this->id,
            'email'  => $this->email,
            'fio'    => $this->fio,
            'role'   => $this->role,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['LIKE', 'date_create', $this->date_create]);

        if (!empty($this->tag)) {
            $userTagQuery = UserTag::find()->select(['user_id'])->andWhere(['tag_id' => $this->tag]);
            $query->andWhere(['IN', 'id', $userTagQuery]);
        }

        if (!empty($this->source)) {
            $userSourceQuery = UserSource::find()->select(['user_id'])->andWhere(['source_id' => $this->source]);
            $query->andWhere(['IN', 'id', $userSourceQuery]);
        }

        return $dataProvider;
    }
}
