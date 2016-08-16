<?php
/** @var \common\models\client\ClientSearch $searchModel */

use yii\grid\GridView;
use yii\widgets\Pjax;
use common\components\helpers\ArrayHelper;
use common\components\helpers\DatePicker;
use common\models\client\Client;

$this->title = 'Список клиентов';

Pjax::begin(['id' => 'clientGrid']);
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'columns'      => [
        'id',
        [
            'attribute' => 'user_id',
            'filter'    => $searchModel->getUserList(),
            'value'     => function ($data) {
                return ArrayHelper::getValue($data->user, 'email');
            }
        ],
        [
            'attribute' => 'status',
            'filter'    => Client::$statusList,
            'value'     => function ($data) {
                return ArrayHelper::getValue(Client::$statusList, $data->status);
            }
        ],
        [
            'attribute' => 'clientFio',
            'value' => function($data){
                return $data->getFio();
            }
        ],
        [
            'attribute' => 'clientPhone',
            'value' => function($data){
                return $data->getPhone();
            }
        ],
        [
            'attribute' => 'date_create',
            'format'    => 'date',
            'filter'    => DatePicker::getInput($searchModel)
        ],
        [
            'class'    => 'common\components\grid\ActionColumn',
            'template' => '{view}',
        ],
    ],
]);
Pjax::end();