<?php
use yii\helpers\Html;
use common\components\widgets\dynamicForm\DynamicFormWidget;

if (empty($modelsAction)) {
    $modelsAction = [new \common\models\process\ProcessStageAction()];
}

$actionList = \common\models\action\Action::getList();

DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicFormAction',
    'widgetBody'      => '.container-actions',
    'widgetItem'      => '.action-item',
    'min'             => 0,
    'limit'           => count($actionList),
    'insertButton'    => '.add-action',
    'deleteButton'    => '.remove-action',
    'model'           => $modelsAction[0],
    'formId'          => 'dynamic-form',
    'formFields'      => [
        'action',
        'reasonData',
        'follow_to_stage_id',
    ],
]);
?>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th class="col-md-4">Действие</th>
            <th class="col-md-4">Причины</th>
            <th class="col-md-3">Перевод в статус</th>
            <th class="text-center">
                <button type="button" class="add-action btn btn-success btn-xs" title="Добавить действие">
                    <span class="glyphicon glyphicon-plus"></span>
                </button>
            </th>
        </tr>
        </thead>

        <tbody class="container-actions">
        <?php foreach ($modelsAction as $indexAction => $modelAction): ?>
            <?php $fieldName = '[' . $indexStage . '][' . $indexAction . ']'; ?>

            <tr class="action-item" data-follow-to="<?= $modelAction->follow_to_stage_id; ?>">
                <td class="vcenter">
                    <?php
                    if (!$modelAction->isNewRecord) {
                        echo Html::activeHiddenInput($modelAction, $fieldName . 'id');
                    }

                    echo $form->field($modelAction, $fieldName . 'action_id')->label(false)
                        ->dropDownList($actionList, ['class' => 'actionSelect']);
                    ?>
                </td>

                <td class="vcenter">
                    <?= $form->field($modelAction, $fieldName . 'reasonData')->label(false)
                        ->widget(\kartik\widgets\Select2::className(), [
                            'data'    => \common\models\reason\Reason::getList(),
                            'options' => [
                                'multiple'    => true,
                                'placeholder' => '',
                            ]
                        ]); ?>
                </td>

                <td class="vcenter">
                    <?= $form->field($modelAction, $fieldName . 'follow_to_stage_id')->label(false)
                        ->dropDownList([], ['class' => 'followToStageSelect']); ?>
                </td>

                <td class="text-center vcenter">
                    <button type="button" class="remove-action btn btn-danger btn-xs">
                        <span class="glyphicon glyphicon-minus"></span>
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php DynamicFormWidget::end(); ?>