<?php
use yiister\gentelella\widgets\grid\GridView;
use yii\widgets\Pjax;
use common\components\helpers\DateHelper;
use common\components\helpers\ManageButton;

$this->title = 'Список процессов';

echo $this->context->getCreateButton('Добавить новый процесс');

Pjax::begin(['id' => 'process-grid']);
echo GridView::widget([
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
            'filter'    => DateHelper::getInput($searchModel)
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
            'template' => '{update} {disable} {activate}',
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
            ]
        ],
    ],
]);
Pjax::end();