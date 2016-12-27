<?php
use yii\helpers\Html;
use common\components\widgets\dynamicForm\DynamicFormWidget;

$modelsContact = $this->context->model->contactData;

DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicFormContact',
    'widgetBody'      => '.container-contacts',
    'widgetItem'      => '.contact-item',
    'insertButton'    => '.add-contact',
    'deleteButton'    => '.remove-contact',
    'model'           => $modelsContact[0],
    'formId'          => 'dynamic-form',
    'formFields'      => [
        'person',
        'type',
        'value',
    ],
]);
?>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>Контактное лицо</th>
            <th>Тип</th>
            <th>Значение</th>
            <th class="text-center" style="width:90px;"></th>
        </tr>
        </thead>

        <tbody class="container-contacts">
        <?php foreach ($modelsContact as $index => $model): ?>
            <?php $fieldName = '[' . $index . ']'; ?>

            <tr class="contact-item">
                <td class="vcenter">
                    <?php
                    if (!$model->isNewRecord) {
                        echo Html::activeHiddenInput($model, $fieldName . 'id');
                    }
                    ?>

                    <?= $form->field($model, $fieldName . 'person')->label(false)
                        ->textInput(['maxlength' => true]); ?>
                </td>

                <td class="vcenter">
                    <?= $form->field($model, $fieldName . 'type')->label(false)
                        ->dropDownList(\common\models\company\CompanyContact::$typeList); ?>
                </td>

                <td class="vcenter">
                    <?= $form->field($model, $fieldName . 'value')->label(false)
                        ->textInput(['maxlength' => true]); ?>
                </td>

                <td class="text-center vcenter" style="width: 90px;">
                    <button type="button" class="remove-contact btn btn-danger btn-xs">
                        <span class="glyphicon glyphicon-minus"></span>
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>

        <tfoot>
        <tr>
            <th colspan="5" class="text-right">
                <button type="button" class="add-contact btn btn-success btn-xs" title="Добавить контакт">
                    <span class="glyphicon glyphicon-plus"></span>Добавить контакт
                </button>
            </th>
        </tr>
        </tfoot>
    </table>

<?php DynamicFormWidget::end(); ?>