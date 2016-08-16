<?php
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\components\helpers\DatePicker;
use common\components\Status;

$this->title = 'Список статусов';

echo $this->context->getCreateButton('Добавить новый статус');

Pjax::begin(['id' => 'stageGrid']);
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'columns'      => [
        'id',
        'name',
        'alias',
        [
            'attribute' => 'call',
            'filter'    => Status::getStatusListYesNo(),
            'value'     => function ($model) {
                return \yii\helpers\ArrayHelper::getValue(Status::getStatusListYesNo(), $model->call);
            }
        ],
        [
            'attribute' => 'date_create',
            'format'    => 'date',
            'filter'    => DatePicker::getInput($searchModel)
        ],
        [
            'class'    => 'common\components\grid\ActionColumn',
            'template' => '{update} {delete}',
        ],
    ],
]);
Pjax::end();