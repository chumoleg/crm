<?php
use yiister\gentelella\widgets\grid\GridView;
use yii\widgets\Pjax;
use common\components\helpers\DatePickerHelper;
use common\components\Status;

$this->title = 'Список действий';

echo $this->context->getCreateButton('Добавить новое действие');

Pjax::begin(['id' => 'actionGrid']);
echo GridView::widget(
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
                'attribute' => 'hold',
                'filter'    => Status::getStatusListYesNo(),
                'value'     => function ($model) {
                    return \yii\helpers\ArrayHelper::getValue(Status::getStatusListYesNo(), $model->hold);
                },
            ],
            [
                'attribute' => 'date_create',
                'format'    => 'date',
                'filter'    => DatePickerHelper::getInput($searchModel),
            ],
            [
                'class'    => 'common\components\grid\ActionColumn',
                'template' => '{update} {delete}',
            ],
        ],
    ]
);
Pjax::end();