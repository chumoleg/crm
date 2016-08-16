<?php
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\components\helpers\DatePicker;

$this->title = 'Список причин для действий';

echo $this->context->getCreateButton('Добавить новую причину');

Pjax::begin(['id' => 'reasonGrid']);
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'columns'      => [
        'id',
        'name',
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