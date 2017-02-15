<?php
use yiister\gentelella\widgets\grid\GridView;
use yii\widgets\Pjax;
use common\components\helpers\DatePicker;
use common\models\transaction\Transaction;

$this->title = 'Список операций';

echo $this->context->getCreateButton('Добавить новую операцию');

Pjax::begin(['id' => 'transaction-grid']);
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'columns'      => [
        'id',
        [
            'attribute' => 'type',
            'filter'    => Transaction::$typeList,
            'value'     => function ($model) {
                return \yii\helpers\ArrayHelper::getValue(Transaction::$typeList, $model->type);
            }
        ],
        'name',
        [
            'attribute' => 'date_create',
            'format'    => 'datetime',
            'filter'    => DatePicker::getInput($searchModel)
        ],
        [
            'class'    => 'common\components\grid\ActionColumn',
            'template' => '{view}',
        ],
    ],
]);
Pjax::end();