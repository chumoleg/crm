<?php
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\components\helpers\DatePicker;

$this->title = 'Список комплектующих';

echo $this->context->getCreateButton('Добавить новую комплектующую');

Pjax::begin(['id' => 'product-component-grid']);
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