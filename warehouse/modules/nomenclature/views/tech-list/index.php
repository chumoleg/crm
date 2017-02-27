<?php
use yiister\gentelella\widgets\grid\GridView;
use yii\widgets\Pjax;
use common\components\helpers\DateHelper;

$this->title = 'Список тех.листов';

echo $this->context->getCreateButton('Добавить новый тех.лист');

Pjax::begin(['id' => 'tech-list-grid']);
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
            'label'  => 'Комплектующие',
            'format' => 'raw',
            'value'  => function ($model) {
                $array = [];
                foreach ($model->techListProductComponents as $techListProductComponent) {
                    $array[] = $techListProductComponent->productComponent->name
                        . ' (' . $techListProductComponent->quantity . ' шт.)';
                }

                return implode(';<br />', $array);

            }
        ],
        [
            'class'    => 'common\components\grid\ActionColumn',
            'template' => '{update} {delete}',
        ],
    ],
]);
Pjax::end();