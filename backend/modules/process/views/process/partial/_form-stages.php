<?php
use yii\helpers\Html;
use common\components\widgets\dynamicForm\DynamicFormWidget;

$modelsStage = $this->context->model->modelsStage;
$modelsAction = $this->context->model->modelsAction;

$stageList = \common\models\stage\Stage::getList();

DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicFormStage',
    'widgetBody'      => '.container-stages',
    'widgetItem'      => '.stage-item',
    'min'             => 1,
    'limit'           => count($stageList),
    'insertButton'    => '.add-stage',
    'deleteButton'    => '.remove-stage',
    'model'           => $modelsStage[0],
    'formId'          => 'dynamic-form',
    'formFields'      => [
        'name',
        'time_limit',
    ],
]);
?>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th class="col-md-3">Статус</th>
            <th class="text-center">Время</th>
            <th class="text-center">Начальный статус</th>
            <th class="col-md-6">Доступные действия</th>
            <th class="text-center" style="width:90px;">
                <button type="button" class="add-stage btn btn-success btn-xs" title="Добавить статус">
                    <span class="glyphicon glyphicon-plus"></span>
                </button>
            </th>
        </tr>
        </thead>

        <tbody class="container-stages">
        <?php foreach ($modelsStage as $indexStage => $modelStage): ?>
            <?php $fieldName = '[' . $indexStage . ']'; ?>

            <tr class="stage-item">
                <td class="vcenter">
                    <?php
                    if (!$modelStage->isNewRecord) {
                        echo Html::activeHiddenInput($modelStage, $fieldName . 'id');
                    }

                    echo $form->field($modelStage, $fieldName . 'stage_id')->label(false)
                        ->dropDownList($stageList, ['class' => 'stageSelect']);
                    ?>
                </td>

                <td class="vcenter">
                    <div class="col-md-6">
                        <?= $form->field($modelStage, $fieldName . 'time_limit')->label(false)
                            ->textInput(['maxlength' => true]); ?>
                    </div>

                    <div class="col-md-6">
                        <?= $form->field($modelStage, $fieldName . 'time_unit')->label(false)
                            ->dropDownList(\common\components\helpers\TimeHelper::$unitList); ?>
                    </div>
                </td>

                <td class="vcenter text-center">
                    <?= $form->field($modelStage, $fieldName . 'first_stage')->label(false)->checkbox(
                        ['class' => 'firstStageCheckBox'], false); ?>
                </td>

                <td>
                    <?= $this->render('_form-actions', [
                        'form'         => $form,
                        'indexStage'   => $indexStage,
                        'modelsAction' => \yii\helpers\ArrayHelper::getValue($modelsAction, $indexStage),
                    ]); ?>
                </td>

                <td class="text-center vcenter" style="width: 90px;">
                    <button type="button" class="remove-stage btn btn-danger btn-xs">
                        <span class="glyphicon glyphicon-minus"></span>
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php DynamicFormWidget::end(); ?>