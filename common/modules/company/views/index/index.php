<?php
use yiister\gentelella\widgets\grid\GridView;
use common\components\helpers\DateHelper;
use common\models\company\Company;
use yii\helpers\Html;
use common\models\user\User;

$this->title = 'Список контактов';

\common\assets\company\CompanyListAsset::register($this);
?>

    <div class="row">
        <div class="col-md-6">
            <?= $this->context->getCreateButton('Добавить новый контакт', null, false); ?>

            <?php if (User::isAdmin()) : ?>
                <div>&nbsp;</div>
                <a href="#" data-toggle="collapse" data-target="#filterBlock">
                    <i class="glyphicon glyphicon-filter"></i> Доп.возможности
                </a>

                <div id="filterBlock" class="collapse">
                    <br/>
                    Перевести выбранные на менеджера:<br/>
                    <?= Html::dropDownList('currentOperatorList', null, $searchModel->getOperatorList(),
                        ['prompt' => '...', 'id' => 'currentOperatorList']); ?>
                    <?= Html::a('Выполнить операцию', '#',
                        ['class' => 'btn btn-danger', 'id' => 'changeCurrentOperatorChecked']); ?>
                    <br/>

                    Перевести все с менеджера:<br/>
                    <?= Html::dropDownList('fromOperatorList', null, $searchModel->getOperatorList(),
                        ['prompt' => '...', 'id' => 'currentOperatorFrom']); ?>
                    на
                    <?= Html::dropDownList('toOperatorList', null, $searchModel->getOperatorList(),
                        ['prompt' => '...', 'id' => 'currentOperatorTo']); ?>

                    <?= Html::a('Выполнить операцию', '#',
                        ['class' => 'btn btn-danger', 'id' => 'changeCurrentOperatorFromTo']); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div>&nbsp;</div>
<?php

echo GridView::widget(
    [
        'id'           => 'companyGrid',
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            [
                'class'   => 'yii\grid\CheckboxColumn',
                'visible' => User::isAdmin(),
            ],
            [
                'attribute'      => 'id',
                'contentOptions' => ['class' => 'idColumn'],
            ],
            [
                'attribute' => 'current_operator',
                'filter'    => $searchModel->getOperatorList(),
                'value'     => 'currentOperator.fio',
                'visible'   => !User::isOperator(),
            ],
//            [
//                'attribute' => 'type',
//                'filter'    => Company::$typeList,
//                'value'     => function ($data) {
//                    return Company::$typeList[$data->type];
//                },
//                'visible'   => !User::isOperator(),
//            ],
//            'brand',
            'name',
            [
                'attribute' => 'date_create',
                'format'    => 'date',
                'filter'    => DateHelper::getInput($searchModel),
            ],
            [
                'class'    => 'common\components\grid\ActionColumn',
                'template' => '{update}',
            ],
        ],
    ]
);