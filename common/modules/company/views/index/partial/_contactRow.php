<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\models\company\CompanyContact;

/** @var CompanyContact $model */
?>

<tr class="rowForRemove">
    <td>
        <?= ArrayHelper::getValue(CompanyContact::$typeList, $model->type); ?>
        <?= Html::hiddenInput($form . '[contactData][' . $counter . '][type]', $model->type); ?>
        <?= Html::hiddenInput('rowCounter', $counter, ['class' => 'rowCounter']); ?>
    </td>
    <td>
        <?= $model->person; ?>
        <?= Html::hiddenInput($form . '[contactData][' . $counter . '][person]', $model->person); ?>
    </td>
    <td>
        <?= $model->value; ?>
        <?= Html::hiddenInput($form . '[contactData][' . $counter . '][value]', $model->value); ?>
    </td>
    <td>
        <?= Html::a('<span class="glyphicon glyphicon-remove"></span>', 'javascript:;', [
            'title' => 'Удалить',
            'class' => 'btn btn-default btn-sm removeRowButton',
        ]); ?>
    </td>
</tr>