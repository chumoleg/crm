<?php
use yiister\gentelella\widgets\grid\GridView;
use yii\widgets\Pjax;
use common\components\helpers\DatePicker;

$this->title = 'Список систем';

echo $this->context->getCreateButton('Добавить новую систему');

Pjax::begin(['id' => 'systemGrid']);
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
                'class'    => 'common\components\grid\ActionColumn',
                'template' => '{manage} {update} {delete}',
                'buttons'  => [
                    'manage' => function ($url, $model) {
                        return \common\components\helpers\ManageButton::manage($url);
                    },
                ],
            ],
        ],
    ]
);
Pjax::end();