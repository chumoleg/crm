<?php

namespace common\components\helpers;

use Yii;
use yii\helpers\Html;

class ManageButton
{
    public static function view($url)
    {
        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
            'title' => Yii::t('yii', 'View'),
            'class' => 'btn btn-default btn-sm',
        ]);
    }

    public static function update($url)
    {
        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
            'title' => Yii::t('yii', 'Update'),
            'class' => 'btn btn-default btn-sm',
        ]);
    }

    public static function delete($url)
    {
        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
            'title'            => Yii::t('yii', 'Delete'),
            'data-confirm-msg' => Yii::t('yii', 'Are you sure you want to delete this item?'),
            'class'            => 'btn btn-default btn-sm pjax-button',
        ]);
    }

    public static function manage($url)
    {
        return Html::a('<span class="glyphicon glyphicon-cog"></span>', $url, [
            'title' => 'Настройка параметров',
            'class' => 'btn btn-default btn-sm',
        ]);
    }

    public static function disable($url)
    {
        return Html::a('<span class="glyphicon glyphicon-off"></span>', $url, [
            'class'            => 'btn btn-default btn-danger btn-sm pjax-button',
            'title'            => 'Выключить',
            'data-confirm-msg' => 'Вы уверены, что хотите выключить этот элемент?',
        ]);
    }

    public static function activate($url)
    {
        return Html::a('<span class="glyphicon glyphicon-off"></span>', $url, [
            'class'            => 'btn btn-default btn-success btn-sm pjax-button',
            'title'            => 'Включить',
            'data-confirm-msg' => 'Вы уверены, что хотите включить этот элемент?',
        ]);
    }
}