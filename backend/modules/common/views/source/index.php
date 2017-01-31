<?php
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\components\helpers\DatePicker;
use common\components\Status;

$this->title = 'Список источников';

echo $this->context->getCreateButton('Добавить новый источник');

Pjax::begin(['id' => 'sourceGrid']);
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
                'attribute' => 'date_create',
                'format'    => 'date',
                'filter'    => DatePicker::getInput($searchModel),
            ],
            [
                'attribute' => 'is_default',
                'filter'    => Status::getStatusListYesNo(),
                'value'     => function ($data) {
                    $statusList = Status::getStatusListYesNo();

                    return $statusList[$data->is_default];
                },
            ],
            [
                'class'    => 'common\components\grid\ActionColumn',
                'template' => '{update} {delete}',
            ],
        ],
    ]
);
Pjax::end();