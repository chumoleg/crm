<?php
use common\models\client\Client;
use common\components\Role;

?>

<div class="row">
    <div class="col-md-1 col-sm-4 col-xs-12">
        <div class="dropdown">
            <button type="button" class="btn btn-default mainMenuButton" data-toggle="dropdown">
                Меню <span class="caret"></span>
            </button>

            <?= \kartik\dropdown\DropdownX::widget([
                'items' => [
                    [
                        'label' => 'Клиенты',
                        'url'   => '/order/client/index'
                    ],
                    [
                        'label' => 'Заказы',
                        'url'   => '/order/order/index',
                    ],
                    [
                        'label'   => '',
                        'options' => ['class' => 'divider'],
                    ],
                    [
                        'label'   => 'Управление (общее)',
                        'url'     => '/management/common/user/index',
                        'visible' => Yii::$app->user->can(Role::ADMIN)
                    ],
                    [
                        'label'   => 'Управление бизнес-процессами',
                        'url'     => '/management/process/action/index',
                        'visible' => Yii::$app->user->can(Role::ADMIN)
                    ],
                    [
                        'label'   => 'Управление внешними системами',
                        'url'     => '/management/system/system/index',
                        'visible' => Yii::$app->user->can(Role::ADMIN)
                    ],
                    [
                        'label'   => 'Отчеты',
                        'url'     => '/report/index/index',
                        'visible' => Yii::$app->user->can(Role::ADMIN)
                    ],
                    [
                        'label' => 'Клиентские базы',
                        'url'   => '/clientBase/index/index',
                    ]
                ],
            ]);
            ?>
        </div>
    </div>

    <div class="col-md-8 col-sm-4 col-xs-12">
        <div class="well borderedBlock text-center">
            <span class="label label-info">Кол-во клиентов: <?= Client::getCountClients(); ?></span>
            <span class="label label-success">Кол-во новых клиентов: <?= Client::getCountClients(true); ?></span>
            <span class="label label-danger">Просрочено: <?= Client::getOverdueClients(); ?></span>
        </div>
    </div>

    <div class="col-md-2 col-sm-2 col-xs-6">
        <div class="text-center borderedBlock">
            <?= Yii::$app->user->identity->email;?>
            <?php
            $workPlace = Yii::$app->user->getWorkPlace();
            if (!empty($workPlace)) {
                echo ' (' . $workPlace . ')';
            }
            ?>
        </div>
    </div>

    <div class="col-md-1 col-sm-2 col-xs-6">
        <a href="/site/logout" class="btn btn-default mainMenuButton">Выход</a>
    </div>
</div>