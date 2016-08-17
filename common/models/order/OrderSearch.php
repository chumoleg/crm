<?php

namespace common\models\order;

use common\components\Status;
use Yii;
use yii\data\ActiveDataProvider;
use common\components\helpers\ArrayHelper;

class OrderSearch extends Order
{
    public $tag_id;
    public $fio;
    public $phone;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'id',
                    'process_id',
                    'current_stage_id',
                    'source_id',
                    'current_user_id',
                    'date_create',
                    'fio',
                    'phone',
                    'tag_id'
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
            'fio'    => 'ФИО клиента',
            'phone'  => 'Телефон',
            'tag_id' => 'Теги',
        ], parent::attributeLabels());
    }

    /**
     * @param array $params
     * @param array $defaultOrder
     *
     * @return ActiveDataProvider
     */
    public function search($params, $defaultOrder = [])
    {
        $query = parent::find()
            ->joinWith('process')
            ->joinWith('currentStage')
            ->joinWith('source')
            ->joinWith('clientPhone')
            ->joinWith('clientPersonalData');

        $dataProvider = $this->getDataProvider($query, $defaultOrder);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        if (Yii::$app->user->can(\common\components\Role::OPERATOR)) {
            $query->andWhere(['order.current_user_id' => Yii::$app->user->id]);
        }

        $query->andFilterWhere([
            'order.id'               => $this->id,
            'order.date_create'      => $this->date_create,
            'order.process_id'       => $this->process_id,
            'order.current_stage_id' => $this->current_stage_id,
            'order.source_id'        => $this->source_id,
            'order.current_user_id'  => $this->current_user_id,
        ]);

        if (!empty($this->tag_id)) {
            $tagId = $this->tag_id;
            $innerQuery = OrderProduct::find()
                ->select(['order_id'])
                ->joinWith([
                    'product.productTags' => function ($q) use ($tagId) {
                        $q->andWhere(['tag_id' => $tagId]);
                    }
                ]);

            $query->andWhere(['IN', 'order.id', $innerQuery]);
        }

        return $dataProvider;
    }

    /**
     * @return array
     */
    public function getCurrentUserList()
    {
        $data = self::find()
            ->joinWith('currentUser')
            ->distinct('current_user_id')
            ->andWhere('current_user_id IS NOT NULL')
            ->all();

        return ArrayHelper::map($data, 'currentUser.id', 'currentUser.email');
    }
}
