<?php
/** @var \common\models\order\OrderSearch $searchModel */

use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Html;
use common\components\helpers\DatePicker;
use common\components\Role;
use common\models\company\Company;

$this->title = $this->context->indexTitle;

if ($this->context->module->accessCreateOrder) {
    if (Yii::$app->user->can(Role::ADMIN)) {
        $checkOrders = \common\models\order\Order::getOrderWithoutProcess(true);
        if ($checkOrders) {
            echo Html::a(
                    'Запуск заказов без процессов',
                    ['/order/order/update-process'],
                    ['class' => 'btn btn-primary']
                ) . '&nbsp;';
        }
    }

//    if ($this->context->id == 'my-order') {
    $companyList = Company::getListCustomers();
    if (!empty($companyList)) {
        echo $this->context->getCreateButton('Заключить новую сделку', ['/order/order-create/index'], false);
    }

    echo Html::a('Список организаций', ['/company/index/index'], ['class' => 'btn btn-default']);

//    } else {
//        echo Html::a('Сделки, заключенные мной', ['/order/my-order/index'], ['class' => 'btn btn-default']);
//    }

    echo Html::tag('div', '&nbsp;');
}

\common\assets\order\OrderListAsset::register($this);

Pjax::begin(['id' => 'orderGrid']);
echo GridView::widget(
    [
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            'id',
            'name',
            [
                'attribute' => 'source_id',
                'filter'    => \common\models\source\Source::getList(),
                'value'     => 'source.name',
            ],
            [
                'attribute' => 'company_executor',
                'filter'    => Company::getListExecutors(),
                'value'     => 'companyExecutor.name',
            ],
            [
                'attribute' => 'company_customer',
                'filter'    => Company::getListCustomers(),
                'value'     => 'companyCustomer.name',
            ],
            [
                'attribute' => 'tag_id',
                'filter'    => \common\models\tag\Tag::getList(),
                'format'    => 'raw',
                'value'     => function ($model) {
                    return $this->render('partial/_tags', ['model' => $model]);
                },
            ],
            [
                'attribute' => 'process_id',
                'filter'    => \common\models\process\Process::getList(),
                'value'     => 'process.name',
            ],
            [
                'attribute' => 'current_stage_id',
                'filter'    => \common\models\stage\Stage::getList(),
                'value'     => 'currentStage.name',
            ],
            [
                'attribute' => 'date_create',
                'format'    => 'datetime',
                'filter'    => DatePicker::getInput($searchModel),
            ],
            [
                'class'    => 'common\components\grid\ActionColumn',
                'template' => '{view}',
            ],
        ],
    ]
);
Pjax::end();