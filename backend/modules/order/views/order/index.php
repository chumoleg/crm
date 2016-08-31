<?php
/** @var \common\models\order\OrderSearch $searchModel */

use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Html;
use common\components\helpers\DatePicker;
use common\components\Role;
use yii\helpers\ArrayHelper;

$this->title = 'Список заказов';

echo $this->context->getCreateButton('Создать новый заказ', ['/order/order-create/index'], false);

$checkOrders = \common\models\order\Order::getOrderWithoutProcess(true);
if ($checkOrders) {
    echo Html::a('Запуск заказов без процессов', \yii\helpers\Url::to(['/order/order/update-process']),
        ['class' => 'btn btn-primary']);
}

echo Html::tag('div', '&nbsp;');

\common\assets\order\OrderListAsset::register($this);

$operatorList = \common\models\user\User::getListByRole(Role::OPERATOR);
$departmentList = \common\components\helpers\DepartmentHelper::$departmentList;

Pjax::begin(['id' => 'orderGrid']);
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'columns'      => [
        'id',
        [
            'attribute' => 'current_user_id',
            'filter'    => $searchModel->getCurrentUserList(),
            'format'    => 'raw',
            'visible'   => Yii::$app->getUser()->can(Role::ADMIN),
            'value'     => function ($data) use ($operatorList) {
                return $this->render('_operatorList', ['model' => $data, 'operatorList' => $operatorList]);
            },
        ],
        [
            'attribute' => 'fio',
            'value'     => 'clientPersonalData.fio'
        ],
        [
            'attribute' => 'phone',
            'value'     => 'clientPhone.phone'
        ],
        [
            'attribute' => 'source_id',
            'filter'    => \common\models\source\Source::getList(),
            'value'     => 'source.name'
        ],
        [
            'attribute' => 'tag_id',
            'filter'    => \common\models\tag\Tag::getList(),
            'format'    => 'raw',
            'value'     => function ($model) {
                return $this->render('partial/_tags', ['model' => $model]);
            }
        ],
        [
            'attribute' => 'process_id',
            'filter'    => \common\models\process\Process::getList(),
            'value'     => 'process.name'
        ],
        [
            'attribute' => 'department',
            'filter'    => $departmentList,
            'value'     => function ($model) use ($departmentList) {
                return ArrayHelper::getValue($departmentList, ArrayHelper::getValue($model, 'currentStage.department'));
            }
        ],
        [
            'attribute' => 'current_stage_id',
            'filter'    => \common\models\stage\Stage::getList(),
            'value'     => 'currentStage.name'
        ],
        [
            'attribute' => 'date_create',
            'format'    => 'datetime',
            'filter'    => DatePicker::getInput($searchModel)
        ],
        [
            'class'    => 'common\components\grid\ActionColumn',
            'template' => '{view}',
        ],
    ],
]);
Pjax::end();