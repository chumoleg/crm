<?php
/** @var \common\models\user\UserSearch $searchModel */

use yii\grid\GridView;
use yii\widgets\Pjax;
use common\components\helpers\ArrayHelper;
use common\components\helpers\DatePicker;
use common\components\Role;

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
            'attribute' => 'date_create',
            'format'    => 'date',
            'filter'    => DatePicker::getInput($searchModel)
        ],
        [
            'class'    => 'common\components\grid\ActionColumn',
            'template' => '{update}',
        ],
    ],
]);
Pjax::end();