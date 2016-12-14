<?php
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;

$modelsProductComponent = $this->context->model->modelsProductComponent;
$productComponentsList = \common\models\productComponent\ProductComponent::getList();

DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicFormTransaction',
    'widgetBody'      => '.container-product-components',
    'widgetItem'      => '.product-component-item',
    'min'             => 1,
    'limit'           => count($productComponentsList),
    'insertButton'    => '.add-product-component',
    'deleteButton'    => '.remove-product-component',
    'model'           => $modelsProductComponent[0],
    'formId'          => 'dynamic-form',
    'formFields'      => [
        'name',
        'quantity',
    ],
]);
?>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th class="col-md-5">Комплектущая</th>
            <th class="col-md-5 text-center">Кол-во</th>
            <th class="col-md-2 text-center" style="width:90px;">
                <button type="button" class="add-product-component btn btn-success btn-xs"
                        title="Добавить комплектующую">
                    <span class="glyphicon glyphicon-plus"></span>
                </button>
            </th>
        </tr>
        </thead>

        <tbody class="container-product-components">
        <?php foreach ($modelsProductComponent as $index => $modelComponent): ?>
            <?php $fieldName = '[' . $index . ']'; ?>

            <tr class="product-component-item">
                <td class="vcenter">
                    <?php
                    if (!$modelComponent->isNewRecord) {
                        echo Html::activeHiddenInput($modelComponent, $fieldName . 'id');
                    }

                    echo $form->field($modelComponent, $fieldName . 'product_component_id')
                        ->label(false)->dropDownList($productComponentsList);
                    ?>
                </td>

                <td class="vcenter">
                    <?= $form->field($modelComponent, $fieldName . 'quantity')->label(false)
                        ->textInput(['maxlength' => true]); ?>
                </td>

                <td class="text-center vcenter" style="width: 90px;">
                    <button type="button" class="remove-product-component btn btn-danger btn-xs"
                            title="Удалить комплектующую">
                        <span class="glyphicon glyphicon-minus"></span>
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php DynamicFormWidget::end(); ?>