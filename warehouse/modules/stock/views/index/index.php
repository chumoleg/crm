<?php
use yiister\gentelella\widgets\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Наличие комплектующих на складе';

Pjax::begin(['id' => 'product-component-stock-grid']);
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'columns'      => [
        'product_component_id',
        [
            'attribute' => 'productComponentName',
            'value'     => 'productComponent.name'
        ],
        'quantity',
        [
            'attribute' => 'date_create',
            'label'     => 'Дата последней операции'
        ],
        [
            'class'    => 'common\components\grid\ActionColumn',
            'template' => '{view}',
        ],
    ],
]);
Pjax::end();