<?php
use yiister\gentelella\widgets\grid\GridView;
use yii\widgets\Pjax;
use common\components\helpers\DateHelper;

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
            'filter'    => DateHelper::getInput($searchModel)
        ],
        [
            'class'    => 'common\components\grid\ActionColumn',
            'template' => '{update} {delete}',
        ],
    ],
]);
Pjax::end();