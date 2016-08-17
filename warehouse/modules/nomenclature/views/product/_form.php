<?php
use kartik\form\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$model = $this->context->model;

$this->context->addBreadCrumb('Список товаров', ['/nomenclature/product/index']);
$this->context->addBreadCrumb($this->title);

\common\assets\FormAppendAsset::register($this);
?>

<?php $form = ActiveForm::begin(['id' => 'productForm']); ?>

    <div class="row">
        <div class="col-md-4">
            <?php
            echo $form->field($model, 'category')->dropDownList(\common\models\product\Product::$categoryList);
            echo $form->field($model, 'name')->textInput();
            echo $form->field($model, 'tagData')->widget(\kartik\widgets\Select2::className(), [
                'data'    => \common\models\tag\Tag::getList(),
                'options' => [
                    'multiple'    => true,
                    'placeholder' => '',
                ]
            ]);

            echo $form->field($model, 'article')->textInput();
            echo $form->field($model, 'description')->textarea();
            ?>
        </div>
        <div class="col-md-5 col-md-offset-1">
            <strong>Цены:</strong>
            <div class="clearfix"></div>
            <table class="table">
                <tbody id="modalFormAppendResult">
                <?php
                if (!empty($model->productPrices)) {
                    foreach ($model->productPrices as $k => $obj) {
                        echo $this->render('partial/_priceRow', [
                            'counter' => $k,
                            'model'   => $obj,
                            'form'    => $model->getReflectionClassName()
                        ]);
                    }
                }
                ?>
                </tbody>
            </table>

            <div class="clearfix"></div>
            <?= Html::button('Добавить цену', [
                'data-url'   => Url::toRoute(['/nomenclature/product/add-price']),
                'data-title' => 'Добавление цены',
                'class'      => 'showModalButton btn btn-default'
            ]); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <?= \common\components\helpers\FormButton::getButtons(); ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>