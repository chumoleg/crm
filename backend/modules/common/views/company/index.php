<?php
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\components\helpers\DatePicker;
use common\models\company\Company;

$this->title = 'Список организаций';

echo $this->context->getCreateButton('Добавить новую организацию');

Pjax::begin(['id' => 'companyGrid']);
echo GridView::widget(
    [
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            'id',
            [
                'attribute' => 'current_operator',
                'filter'    => $searchModel->getOperatorList(),
                'value'     => 'currentOperator.fio',
            ],
            [
                'attribute' => 'type',
                'filter'    => Company::$typeList,
                'value'     => function ($data) {
                    return Company::$typeList[$data->type];
                },
            ],
            'name',
            'brand',
            [
                'attribute' => 'date_create',
                'format'    => 'date',
                'filter'    => DatePicker::getInput($searchModel),
            ],
            [
                'class'    => 'common\components\grid\ActionColumn',
                'template' => '{update}',
            ],
        ],
    ]
);
Pjax::end();