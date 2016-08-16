<?php
use kartik\editable\Editable;
use common\models\system\SystemStage;
use yii\helpers\ArrayHelper;

$system = $this->context->model;
$values = ArrayHelper::map($system->systemStages, 'stage_id', 'foreign_status');
?>

<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered">
            <?php foreach (\common\models\stage\Stage::getList() as $stageId => $stageName) : ?>
                <?php $systemStage = SystemStage::getModelBySystemAndStage($system->id, $stageId); ?>
                <tr>
                    <td><?= $stageName; ?></td>
                    <td>
                        <?php
                        echo Editable::widget([
                            'name'   => 'foreign_status',
                            'value' => ArrayHelper::getValue($values, $stageId),
                            'formOptions' => [
                                'action' => [
                                    'editable-stage',
                                    'system' => $system->id,
                                    'stage'  => $stageId
                                ]
                            ],
                            'size'        => 'md',
                            'options'     => [
                                'class'       => 'form-control',
                                'placeholder' => 'Значение во внешней системе'
                            ]
                        ]);
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>