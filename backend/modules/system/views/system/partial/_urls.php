<?php
use kartik\editable\Editable;
use common\models\system\SystemUrl;
use yii\helpers\ArrayHelper;

$system = $this->context->model;
$values = ArrayHelper::map($system->systemUrls, 'type', 'url');
?>

<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered">
            <?php foreach (SystemUrl::$typeList as $type => $name) : ?>
                <?php $systemStage = SystemUrl::getModelBySystemAndType($system->id, $type); ?>
                <tr>
                    <td><?= $name; ?></td>
                    <td>
                        <?php
                        echo Editable::widget([
                            'name'        => 'url',
                            'value'       => ArrayHelper::getValue($values, $type),
                            'formOptions' => [
                                'action' => [
                                    'editable-url',
                                    'system' => $system->id,
                                    'type'   => $type
                                ]
                            ],
                            'size'        => 'md',
                            'options'     => [
                                'class'       => 'form-control',
                                'placeholder' => 'API URL внешней системы'
                            ]
                        ]);
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>