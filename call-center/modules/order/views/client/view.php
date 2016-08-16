<?php

/* @var $this yii\web\View */
/* @var $model Client */

use common\models\client\Client;
use yii\helpers\Html;

$this->title = 'Клиент #' . $this->context->model->id;

$this->context->addBreadCrumb('Список клиентов', ['/order/client/index']);
$this->context->addBreadCrumb($this->title);
?>

<?= Html::hiddenInput('clientId', $this->context->model->id, ['id' => 'clientId']); ?>

<div class="row">
    <div class="col-md-12">
        <div class="borderedBlock orderInnerBlock">
            <div class="row">
                <div class="col-md-4">
                    <?= $this->render('partial/personalData'); ?>
                    <div class="clearfix"></div>
                    <?= $this->render('partial/management'); ?>
                </div>

                <div class="col-md-8">
                    <?= $this->render('partial/orders'); ?>
                </div>
            </div>
        </div>
    </div>
</div>