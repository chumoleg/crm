<?php
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use common\models\company\CompanyContact;
use yii\widgets\Pjax;

/** @var \common\models\order\Order $model */
$model = $this->context->model;

$disabled = !$model->checkAccessManageOrder();
$companyCustomer = $model->companyCustomer;
?>


<div class="borderedBlock topBlock">
    <legend><?= $companyCustomer->getName(); ?></legend>

    <?php Pjax::begin(['id' => 'companyContactBlock']); ?>
    <table class="table tabel-condensed">
        <thead>
        <tr>
            <th>Контактное лицо</th>
            <th>Тип контакта</th>
            <th>Значение</th>
        </tr>
        </thead>

        <?php foreach ($companyCustomer->companyContacts as $companyContact) : ?>
            <tr>
                <td><?= $companyContact->person; ?></td>
                <td><?= ArrayHelper::getValue(CompanyContact::$typeList, $companyContact->type); ?></td>
                <td><?= $companyContact->value; ?></td>
                <td>
                    <?php if ($model->accessCalling() && $companyContact->type == CompanyContact::TYPE_PHONE) : ?>
                        <button class="btn btn-sm btn-success callOrder" data-contact="<?= $companyContact->id; ?>">
                            <?= Html::icon('earphone', ['title' => 'Позвонить']); ?>
                        </button>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php Pjax::end(); ?>

    <?php if ($model->checkAccessManageOrder()) : ?>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 text-right">
                <?= Html::button(
                    'Добавить новый контакт',
                    [
                        'data-url'   => \yii\helpers\Url::to(['/order/ajax/index/contact-form', 'id' => $model->id]),
                        'data-title' => 'Добавление нового контакта',
                        'class'      => 'showModalButton btn btn-default',
                    ]
                ); ?>
            </div>
        </div>
        <div class="clearfix"></div>
    <?php endif; ?>
</div>