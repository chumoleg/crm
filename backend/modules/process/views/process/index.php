<?php
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\components\helpers\DatePicker;
use common\components\helpers\ManageButton;
use common\models\process\Process;

$this->title = 'Список процессов';

echo $this->context->getCreateButton('Добавить новый процесс');

Pjax::begin(['id' => 'productGrid']);
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'columns'      => [
        'id',
        [
            'attribute' => 'type',
            'filter'    => Process::$typeList,
            'value'     => function ($data) {
                return \yii\helpers\ArrayHelper::getValue(Process::$typeList, $data->type);
            }
        ],
        'name',
        [
            'attribute' => 'date_create',
            'format'    => 'date',
            'filter'    => DatePicker::getInput($searchModel)
        ],
        [
            'attribute' => 'status',
            'filter'    => \common\components\Status::getStatusList(),
            'value'     => function ($data) {
                return $data->getStatusLabel();
            }
        ],
        [
            'label'  => 'Для источников',
            'filter' => false,
            'format' => 'html',
            'value'  => function ($data) {
                $array = [];
                foreach ($data->processSources as $processSource) {
                    $array[] = $processSource->source->name;
                }

                return implode(';<br />', $array);
            }
        ],
        [
            'class'    => 'common\components\grid\ActionColumn',
            'template' => '{update} {manage-user} {disable} {activate}',
            'buttons'  => [
                'disable'   => function ($url, $model) {
                    if ($model->isActive()) {
                        return ManageButton::disable($url);
                    }
                },
                'activate'  => function ($url, $model) {
                    if ($model->isDisabled()) {
                        return ManageButton::activate($url);
                    }
                },
                'manage-user' => function ($url, $model) {
                    $url = ['process-user/index', 'id' => $model->id];
                    return ManageButton::manage($url);
                },
            ]
        ],
    ],
]);
Pjax::end();