<?php

/* @var $this yii\web\View */
/* @var $model Order */

use common\models\order\Order;
use yii\helpers\Html;

\common\assets\order\OrderAsset::register($this);

$this->title = 'Сделка #' . $this->context->model->id;

$this->context->addBreadCrumb('Список сделок', ['index']);
$this->context->addBreadCrumb($this->title);
?>

<?= Html::hiddenInput('orderId', $this->context->model->id, ['id' => 'orderId']); ?>

<div class="row">
    <div class="col-md-12">
        <div class="borderedBlock orderInnerBlock">
            <div class="row">
                <div class="col-md-4">
                    <?= $this->render('partial/orderForm'); ?>
                </div>

                <div class="col-md-6">
                    <?= $this->render('partial/products'); ?>
                </div>

                <div class="col-md-2">
                    <?= $this->render('partial/stageInfo'); ?>
                </div>
            </div>

            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-9">
                    <?= $this->render('partial/comments'); ?>
                </div>

                <div class="col-md-3">
                    <?= $this->render('partial/management'); ?>
                </div>
            </div>
        </div>
    </div>
</div>