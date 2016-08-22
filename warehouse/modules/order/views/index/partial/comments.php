<?php
/** @var \warehouse\models\order\Order $model */
$model = $this->context->model;
?>

<div class="borderedBlock orderInnerBlock">
    <div class="row" id="orderCommentBlock">
        <?= $this->render('@app/modules/order/modules/ajax/views/order-manage/commentList',
            ['commentsList' => $model->orderComments]); ?>
    </div>

    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12">
            <?= \yii\helpers\Html::textInput('fieldTextComment', null, [
                'id'          => 'fieldTextComment',
                'placeholder' => 'Введите текст комментария ...',
                'class'       => 'form-control'
            ]); ?>
        </div>
    </div>
</div>