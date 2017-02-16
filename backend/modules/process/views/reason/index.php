<?php
use yiister\gentelella\widgets\grid\GridView;
use yii\widgets\Pjax;
use common\components\helpers\DatePickerHelper;

$this->title = 'Список причин для действий';

echo $this->context->getCreateButton('Добавить новую причину');

Pjax::begin(['id' => 'reasonGrid']);
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