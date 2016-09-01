<?php

use \kartik\form\ActiveForm;
use common\models\user\User;

$this->title = 'Процесс "' . $process->name . '". Назначение операторов';

$this->context->addBreadCrumb('Список процессов', ['/process/process/index']);
$this->context->addBreadCrumb($this->title);

$operators = User::getListByRole(\common\components\Role::OPERATOR);
?>

<?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th class="col-md-4">Статус</th>
                    <th class="col-md-5">Операторы</th>
                    <th class="col-md-3">Тип выбора</th>
                </tr>
                </thead>

                <?php foreach ($process->processStages as $processStage) : ?>
                    <?php $fieldKey = $processStage->stage_id; ?>
                    <tr>
                        <td><?= $processStage->stage->name; ?></td>
                        <td>
                            <?= $form->field($model, 'operatorList[' . $fieldKey . ']')->label(false)
                                ->widget(\kartik\widgets\Select2::className(), [
                                    'data'    => $operators,
                                    'options' => [
                                        'multiple'    => true,
                                        'placeholder' => '',
                                    ]
                                ]); ?>
                        </td>
                        <td><?= $form->field($model, 'typeSearchOperatorList[' . $fieldKey . ']')->label(false)
                                ->dropDownList(\common\components\helpers\TypeSearchOperatorHelper::$typeList); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>

    <div class="clearfix"></div>
<?= \common\components\helpers\FormButton::getButtons(['/process/index/index']); ?>

<?php ActiveForm::end(); ?>