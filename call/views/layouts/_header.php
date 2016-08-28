<?php
use common\models\client\Client;

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
                        'url'   => ['/order/client/index']
                    ],
                    [
                        'label' => 'Заказы',
                        'url'   => ['/order/order/index'],
                    ],
                    [
                        'label' => 'Клиентские базы',
                        'url'   => ['/clientBase/index/index'],
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
            <?php
            echo Yii::$app->getUser()->getIdentity()->email;
            $workPlace = Yii::$app->getUser()->getWorkPlace();
            if (!empty($workPlace)) {
                echo ' (' . $workPlace . ')';
            }
            ?>
        </div>
    </div>

    <div class="col-md-1 col-sm-2 col-xs-6">
        <a href="<?= 'http://' . Yii::$app->params['baseUrl']; ?>" class="btn btn-default mainMenuButton">Выход</a>
    </div>
</div>