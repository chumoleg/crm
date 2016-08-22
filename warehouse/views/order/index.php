<?php
/** @var \common\models\order\OrderSearch $searchModel */

use yii\grid\GridView;
use yii\widgets\Pjax;
use common\components\helpers\DatePicker;
use common\components\Role;

$this->title = 'Список заказов';

$operatorList = \common\models\user\User::getListByRole(Role::OPERATOR);

Pjax::begin(['id' => 'orderGrid']);
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'columns'      => [
        'id',
        [
            'attribute' => 'current_user_id',
            'filter'    => $searchModel->getCurrentUserList(),
            'visible'   => Yii::$app->user->can(Role::ADMIN),
            'value'     => function ($data) {
                return \common\components\helpers\ArrayHelper::getValue($data->currentUser, 'email');
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
            'attribute' => 'tag',
            'filter'    => false,
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