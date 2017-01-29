<?php
/** @var \common\models\user\UserSearch $searchModel */

use yii\grid\GridView;
use yii\widgets\Pjax;
use common\components\helpers\ArrayHelper;
use common\components\helpers\DatePicker;
use common\components\Role;
use common\components\helpers\ManageButton;

$this->title = 'Список пользователей';

echo $this->context->getCreateButton('Добавить нового пользователя');

Pjax::begin(['id' => 'userGrid']);
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'columns'      => [
        'id',
        'email',
        'fio',
        [
            'attribute' => 'role',
            'filter'    => Role::$rolesList,
            'value'     => function ($data) {
                return ArrayHelper::getValue(Role::$rolesList, $data->role);
            }
        ],
        [
            'attribute' => 'tag',
            'filter'    => \common\models\tag\Tag::getList(),
            'format'    => 'raw',
            'value'     => function ($model) {
                return $this->render('_tags', ['model' => $model]);
            }
        ],
        [
            'attribute' => 'source',
            'filter'    => \common\models\source\Source::getList(),
            'format'    => 'raw',
            'value'     => function ($model) {
                return implode(', ', ArrayHelper::getColumn($model->userSources, 'source.name'));
            }
        ],
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
            'class'         => 'common\components\grid\ActionColumn',
            'headerOptions' => ['width' => '90'],
            'template'      => '{update} {disable} {activate}',
            'buttons'       => [
                'disable'  => function ($url, $model) {
                    if ($model->isActive()) {
                        return ManageButton::disable($url);
                    }
                },
                'activate' => function ($url, $model) {
                    if ($model->isDisabled()) {
                        return ManageButton::activate($url);
                    }
                },
            ]
        ],
    ],
]);
Pjax::end();