<?php
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\components\helpers\DatePicker;
use common\models\clientBaseFile\ClientBaseFile;

$this->title = 'Список загруженных данных';

Pjax::begin(['id' => 'clientBaseFileDataGrid']);
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'columns'      => [
        'id',
        [
            'attribute' => 'client_base_file_id',
            'filter'    => ClientBaseFile::getList(),
            'value'     => 'clientBaseFile.client_name'
        ],
        'fio',
        'phone',
        [
            'attribute' => 'data',
            'filter'    => false,
            'value'     => function ($model) {
                $array = $model->getData();
                if (empty($array)) {
                    return null;
                }

                return implode('<br />', $array);
            }
        ],
        [
            'attribute' => 'date_create',
            'format'    => 'date',
            'filter'    => DatePicker::getInput($searchModel)
        ],
    ],
]);
Pjax::end();