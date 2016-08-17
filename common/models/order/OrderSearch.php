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
    public $currentStage;

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
                    'source_id',
                    'currentStage',
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
            'fio'          => 'ФИО клиента',
            'phone'        => 'Телефон',
            'currentStage' => 'Текущий статус',
            'tag_id'       => 'Теги',
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
            ->joinWith('process')
            ->joinWith('source')
            ->joinWith('clientPhone')
            ->joinWith('clientPersonalData');

        $dataProvider = $this->getDataProvider($query);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        if (Yii::$app->user->can(\common\components\Role::OPERATOR)) {
            $query->andWhere(['order.current_user_id' => Yii::$app->user->id]);
        }

        $query->andFilterWhere([
            'order.id'              => $this->id,
            'order.date_create'     => $this->date_create,
            'order.process_id'      => $this->process_id,
            'order.source_id'       => $this->source_id,
            'order.current_user_id' => $this->current_user_id
        ]);

        if (!empty($this->currentStage)) {
            $innerQuery = OrderStage::find()
                ->select(['order_id'])
                ->andWhere(['stage_id' => $this->currentStage])
                ->andWhere(['status' => Status::STATUS_ACTIVE]);

            $query->andWhere(['IN', 'order.id', $innerQuery]);
        }

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
