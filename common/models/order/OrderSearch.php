<?php

namespace common\models\order;

use Yii;
use yii\data\ActiveDataProvider;
use common\models\stage\StageMethod;
use common\models\user\User;
use common\components\helpers\DepartmentHelper;
use common\components\helpers\ArrayHelper;

class OrderSearch extends Order
{
    public $tag_id;
    public $fio;
    public $phone;
    public $department;
    public $currentOperator;

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
                    'company_customer',
                    'company_executor',
                    'process_id',
                    'current_stage_id',
                    'department',
                    'source_id',
                    'date_create',
                    'time_postponed',
                    'fio',
                    'phone',
                    'tag_id',
                    'currentOperator',
                ],
                'safe',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(
            [
                'fio'             => 'ФИО клиента',
                'phone'           => 'Телефон',
                'tag_id'          => 'Теги',
                'department'      => 'Отдел',
                'currentOperator' => 'Менеджер',
            ],
            parent::attributeLabels()
        );
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
            ->joinWith(
                [
                    'companyCustomer' => function ($q) {
                        $q->alias('customer');
                    },
                ]
            )
            ->joinWith(
                [
                    'companyExecutor' => function ($q) {
                        $q->alias('executor');
                    },
                ]
            );

        $dataProvider = $this->getDataProvider($query, $defaultOrder);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        $this->_compareWithCurrentApp($query);

        if (User::isOperator()) {
            $query->andWhere(['customer.current_operator' => Yii::$app->user->id]);
        }

        if (!empty($this->currentOperator)) {
            $query->andWhere(['customer.current_operator' => $this->currentOperator]);
        }

        $query->andFilterWhere(
            [
                'order.id'               => $this->id,
                'order.company_executor' => $this->company_executor,
                'order.company_customer' => $this->company_customer,
                'order.process_id'       => $this->process_id,
                'order.current_stage_id' => $this->current_stage_id,
                'order.source_id'        => $this->source_id,
                'stage.department'       => $this->department,
            ]
        );

        $query->andFilterWhere(['LIKE', 'order.name', $this->name]);
        $query->andFilterWhere(['LIKE', 'order.date_create', $this->date_create]);
        $query->andFilterWhere(['LIKE', 'order.time_postponed', $this->time_postponed]);

        if (!empty($this->tag_id)) {
            $tagId = $this->tag_id;
            $innerQuery = OrderProduct::find()
                ->select(['order_id'])
                ->joinWith(
                    [
                        'product.productTags' => function ($q) use ($tagId) {
                            $q->andWhere(['tag_id' => $tagId]);
                        },
                    ]
                );

            $query->andWhere(['IN', 'order.id', $innerQuery]);
        }

        if (empty($this->current_stage_id)) {
            $closeListStages = StageMethod::getStagesList(StageMethod::HIDE_ORDER_FROM_LIST);
            $query->andWhere(['NOT IN', 'stage.id', $closeListStages]);
        }

        $postponedKey = Yii::$app->session->get(self::POSTPONED_SESSION_KEY);
        if (!empty($postponedKey)) {
            $dateTo = $this->_getPostponedFilterDates($postponedKey);
            $query->andWhere('order.time_postponed <= "' . $dateTo . '"');
        }

        return $dataProvider;
    }

    private function _getPostponedFilterDates($postponedKey)
    {
        $dateTo = date('Y-m-d');
        if ($postponedKey == self::POSTPONED_ON_WEEK) {
            $dateTo = date('Y-m-d', strtotime('+6 days'));

        } elseif ($postponedKey == self::POSTPONED_ON_MONTH) {
            $dateTo = date('Y-m-d', strtotime('+30 days'));
        }

        return $dateTo;
    }

    private function _compareWithCurrentApp($query)
    {
        $department = DepartmentHelper::getDepartmentByApplication();
        if (empty($department) || $department == DepartmentHelper::CRM) {
            return;
        }

        $query->andWhere(['stage.department' => $department]);
    }
}
