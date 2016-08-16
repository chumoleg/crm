<?php
use yii\helpers\Html;
use common\models\geo\GeoRegion;
use common\models\geo\GeoArea;
use yii\helpers\ArrayHelper;

/** @var \common\models\order\Order $model */
$model = $this->context->model;
$address = $model->address;
$region = ArrayHelper::getValue($address, 'area.region_id');

$disabled = !$model->checkAccessManageOrder();
?>

<?php $form = \kartik\form\ActiveForm::begin(['id' => 'orderForm']); ?>
    <div class="row">
        <div class="col-md-4">
            ФИО
        </div>
        <div class="col-md-8">
            <?= Html::textInput('fio', $model->client->getFio(),
                ['class' => 'form-control', 'disabled' => $disabled]); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            Телефон
        </div>
        <div class="col-md-8">
            <?= Html::textInput('phone', $model->client->getPhone(),
                ['class' => 'form-control', 'disabled' => $disabled]); ?>
        </div>
    </div>

    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-4">
            ФО
        </div>
        <div class="col-md-8">
            <?= Html::dropDownList('region', $region, GeoRegion::getList(),
                ['class' => 'form-control', 'id' => 'regionSelect', 'disabled' => $disabled]); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            Область
        </div>
        <div class="col-md-8">
            <?= Html::dropDownList('area_id', ArrayHelper::getValue($address, 'area_id'),
                GeoArea::getListByRegion($region),
                ['class' => 'form-control', 'id' => 'areaSelect', 'disabled' => $disabled]); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            Почтовый индекс
        </div>
        <div class="col-md-8">
            <?= Html::textInput('post_index', ArrayHelper::getValue($address, 'post_index'),
                ['class' => 'form-control', 'disabled' => $disabled]); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            Город
        </div>
        <div class="col-md-8">
            <?= Html::textInput('city', ArrayHelper::getValue($address, 'city'),
                ['class' => 'form-control', 'disabled' => $disabled]); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            Улица
        </div>
        <div class="col-md-8">
            <?= Html::textInput('street', ArrayHelper::getValue($address, 'street'),
                ['class' => 'form-control', 'disabled' => $disabled]); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            Дом
        </div>
        <div class="col-md-8">
            <?= Html::textInput('house', ArrayHelper::getValue($address, 'house'),
                ['class' => 'form-control', 'disabled' => $disabled]); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            Квартира/офис
        </div>
        <div class="col-md-8">
            <?= Html::textInput('apartment', ArrayHelper::getValue($address, 'apartment'),
                ['class' => 'form-control', 'disabled' => $disabled]); ?>
        </div>
    </div>
<?php $form->end(); ?>