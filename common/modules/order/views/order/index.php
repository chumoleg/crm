<?php
/** @var \common\models\order\OrderSearch $searchModel */

use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Html;
use common\components\helpers\DatePicker;
use common\components\Role;

$this->title = $this->context->indexTitle;

if ($this->context->module->accessCreateOrder) {
    if ($this->context->id == 'my-order') {
        echo $this->context->getCreateButton('Заключить новую сделку', ['/order/order-create/index'], false);
        echo Html::a('Список сделок в работе', ['/order/order/index'], ['class' => 'btn btn-default']);
    } else {
        echo Html::a('Список моих сделок', ['/order/my-order/index'], ['class' => 'btn btn-default']);
    }

    echo Html::tag('div', '&nbsp;');
}


\common\assets\order\OrderListAsset::register($this);

$operatorList = \common\models\user\User::getListByRole(Role::OPERATOR);

Pjax::begin(['id' => 'orderGrid']);
echo GridView::widget(
    [
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            'id',
            [
                'attribute' => 'current_user_id',
                'filter'    => $searchModel->getCurrentUserList(),
                'format'    => 'raw',
                'visible'   => Yii::$app->user->can(Role::ADMIN),
                'value'     => function ($data) use ($operatorList) {
                    return $this->render('_operatorList', ['model' => $data, 'operatorList' => $operatorList]);
                },
            ],
            [
                'attribute' => 'source_id',
                'filter'    => \common\models\source\Source::getList(),
                'value'     => 'source.name',
            ],
            [
                'attribute' => 'company_id',
                'filter'    => \common\models\company\Company::getList(),
                'value'     => 'company.name',
            ],
            [
                'attribute' => 'tag_id',
                'filter'    => \common\models\tag\Tag::getList(),
                'format'    => 'raw',
                'value'     => function ($model) {
                    return $this->render('partial/_tags', ['model' => $model]);
                },
            ],
            [
                'attribute' => 'process_id',
                'filter'    => \common\models\process\Process::getList(),
                'value'     => 'process.name',
            ],
            [
                'attribute' => 'current_stage_id',
                'filter'    => \common\models\stage\Stage::getList(),
                'value'     => 'currentStage.name',
            ],
            [
                'attribute' => 'date_create',
                'format'    => 'datetime',
                'filter'    => DatePicker::getInput($searchModel),
            ],
            [
                'class'    => 'common\components\grid\ActionColumn',
                'template' => '{view}',
            ],
        ],
    ]
);
Pjax::end();