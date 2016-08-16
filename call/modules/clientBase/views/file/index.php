<?php
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\components\helpers\DatePicker;

$this->title = 'Список загруженных файлов';

Pjax::begin(['id' => 'clientBaseFileGrid']);
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'columns'      => [
        'id',
        'client_name',
        'countRows',
        [
            'attribute' => 'date_create',
            'format'    => 'date',
            'filter'    => DatePicker::getInput($searchModel)
        ],
        [
            'class'    => 'common\components\grid\ActionColumn',
            'template' => '{manage}',
            'buttons'  => [
                'manage' => function ($url, $model) {
                    $url = ['data', 'id' => $model->id];
                    return \common\components\helpers\ManageButton::manage($url);
                }
            ]
        ],
    ],
]);
Pjax::end();