<?php
use yiister\gentelella\widgets\grid\GridView;
use yii\widgets\Pjax;
use common\components\helpers\DateHelper;
use common\models\project\Project;

$this->title = 'Список проектов';

echo $this->context->getCreateButton('Добавить новый проект');

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
                'filter'    => Project::$labelClassList,
                'value'     => function ($model) {
                    return \yii\helpers\ArrayHelper::getValue(Project::$labelClassList, $model->label_class);
                },
            ],
            'comment',
            [
                'attribute' => 'date_create',
                'format'    => 'date',
                'filter'    => DateHelper::getInput($searchModel),
            ],
            [
                'class'    => 'common\components\grid\ActionColumn',
                'template' => '{update} {delete}',
            ],
        ],
    ]
);
Pjax::end();