<?php
use yiister\gentelella\widgets\grid\GridView;
use yii\widgets\Pjax;
use common\components\helpers\DatePickerHelper;
use common\models\tag\Tag;

$this->title = 'Список тегов';

echo $this->context->getCreateButton('Добавить новый тег');

Pjax::begin(['id' => 'tagGrid']);
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
                'attribute' => 'label_class',
                'filter'    => Tag::$labelClassList,
                'value'     => function ($model) {
                    return \yii\helpers\ArrayHelper::getValue(Tag::$labelClassList, $model->label_class);
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