<?php
/** @var \common\models\order\OrderSearch $searchModel */

use yiister\gentelella\widgets\grid\GridView;
use yii\helpers\Html;
use common\components\helpers\DatePicker;
use common\models\company\Company;
use common\models\user\User;
use common\models\order\Order;
use kartik\select2\Select2;

$this->title = $this->context->indexTitle;

\common\assets\order\OrderListAsset::register($this);

$companyList = Company::getListCustomers();
?>

    <div class="row">
        <div class="col-md-6">
            <?php
            if ($this->context->module->accessCreateOrder) {
                if (\common\models\user\User::isAdmin()) {
                    $checkOrders = \common\models\order\Order::getOrderWithoutProcess(true);
                    if ($checkOrders) {
                        echo Html::a(
                                'Запуск заказов без процессов',
                                ['/order/order/update-process'],
                                ['class' => 'btn btn-primary']
                            ) . '&nbsp;';
                    }
                }

                if (!empty($companyList)) {
                    echo $this->context->getCreateButton(
                        'Заключить новую сделку',
                        ['/order/order-create/index'],
                        false
                    );
                }
            }
            ?>
        </div>

        <div class="col-md-6 text-right">
            Отложенные:
            <?php
            $currentSelected = Yii::$app->session->get(Order::POSTPONED_SESSION_KEY);
            foreach (Order::$postponedFilterList as $key => $label) {
                $class = $currentSelected == $key ? 'btn-success' : 'btn-default';
                echo Html::a(
                        $label,
                        'javascript:;',
                        ['class' => 'changeCurrentPostponedFilter btn ' . $class, 'data-key' => $key]
                    ) . '&nbsp;';
            }
            ?>
        </div>
    </div>

<?= GridView::widget(
    [
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            [
                'attribute'      => 'id',
                'contentOptions' => ['class' => 'idColumn'],
            ],
            'name',
            [
                'attribute' => 'source_id',
                'filter'    => \common\models\source\Source::getList(),
                'value'     => 'source.name',
            ],
//            [
//                'attribute' => 'company_executor',
//                'filter'    => Company::getListExecutors(),
//                'value'     => 'companyExecutor.name',
//            ],
            [
                'attribute' => 'company_customer',
                'filter'    => Select2::widget(
                    [
                        'data'          => $companyList,
                        'model'         => $searchModel,
                        'attribute'     => 'company_customer',
                        'options'       => [
                            'placeholder' => '',
                            'allowClear'  => true,
                        ],
                        'pluginOptions' => ['allowClear' => true],
                    ]
                ),
                'value'     => 'companyCustomer.name',
            ],
            [
                'attribute' => 'currentOperator',
                'filter'    => Select2::widget(
                    [
                        'data'          => User::getListByRole(\common\components\Role::OPERATOR),
                        'model'         => $searchModel,
                        'attribute'     => 'currentOperator',
                        'options'       => [
                            'placeholder' => '',
                            'allowClear'  => true,
                        ],
                        'pluginOptions' => ['allowClear' => true],
                    ]
                ),
                'value'     => 'companyCustomer.currentOperator.fio',
                'visible'   => User::isAdmin(),
            ],
            [
                'attribute' => 'tag_id',
                'filter'    => \common\models\tag\Tag::getList(),
                'format'    => 'raw',
                'value'     => function ($model) {
                    return $this->render('partial/_tags', ['model' => $model]);
                },
            ],
//            [
//                'attribute' => 'process_id',
//                'filter'    => \common\models\process\Process::getList(),
//                'value'     => 'process.name',
//            ],
            [
                'attribute' => 'current_stage_id',
                'filter'    => Select2::widget(
                    [
                        'data'          => \common\models\stage\Stage::getList(),
                        'model'         => $searchModel,
                        'attribute'     => 'current_stage_id',
                        'options'       => [
                            'placeholder' => '',
                            'allowClear'  => true,
                        ],
                        'pluginOptions' => ['allowClear' => true],
                    ]
                ),
                'value'     => 'currentStage.name',
            ],
            [
                'attribute' => 'date_create',
                'format'    => 'datetime',
                'filter'    => DatePicker::getInput($searchModel),
            ],
            [
                'attribute' => 'time_postponed',
                'format'    => 'datetime',
                'filter'    => DatePicker::getInput($searchModel, 'time_postponed'),
            ],
            [
                'class'    => 'common\components\grid\ActionColumn',
                'template' => '{view}',
            ],
        ],
    ]
);