<?php
use yii\helpers\Html;

/** @var \common\models\order\Order $model */
$model = $this->context->model;

?>

<div class="borderedBlock topBlock">
    <div id="orderProductsBlock">
        <?= $this->render('_productsTable'); ?>
    </div>

    <?php if ($model->accessManageProducts()) : ?>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 text-right">
                <?= Html::button('Добавить товар', [
                    'data-url'   => \yii\helpers\Url::to([
                        '/order/ajax/index/product-list',
                        'type' => \common\models\product\ProductPrice::TYPE_ADDITIONAL
                    ]),
                    'data-title' => 'Добавление товара',
                    'class'      => 'showModalButton btn btn-default'
                ]); ?>
            </div>
        </div>
        <div class="clearfix"></div>
    <?php endif; ?>

    <?php
    $companyList = \common\models\company\Company::getListCustomers();
    if (!empty($companyList)) {
        echo $this->context->getCreateButton('Заключить новую сделку',
            ['/order/order-create/index', 'company' => $model->company_customer], false);
    }
    ?>
</div>