<?php
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\components\helpers\DatePicker;
use yii\helpers\ArrayHelper;

$this->title = 'Список статусов';

echo $this->context->getCreateButton('Добавить новый статус');

$departmentList = \common\components\helpers\DepartmentHelper::$departmentList;

Pjax::begin(['id' => 'stageGrid']);
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
            'alias',
            [
                'attribute' => 'department',
                'filter'    => $departmentList,
                'value'     => function ($model) use ($departmentList) {
                    return ArrayHelper::getValue($departmentList, $model->department);
                },
            ],
            [
                'label'  => 'Методы',
                'format' => 'raw',
                'value'  => function ($model) {
                    $array = [];
                    foreach ($model->stageMethods as $stageMethod) {
                        $array[] = ArrayHelper::getValue(
                            \common\models\stage\StageMethod::$methodList,
                            $stageMethod->method
                        );
                    }

                    return implode(';<br />', $array);
                },
            ],
            [
                'attribute' => 'date_create',
                'format'    => 'date',
                'filter'    => DatePicker::getInput($searchModel),
            ],
            [
                'class'    => 'common\components\grid\ActionColumn',
                'template' => '{update} {delete}',
            ],
        ],
    ]
);
Pjax::end();