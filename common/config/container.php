<?php

Yii::$container->set('yii\widgets\Pjax', [
    'options' => [
        'class' => 'pjax-wrapper',
    ],
]);

\Yii::$container->set('yii\i18n\Formatter', [
    'dateFormat'        => 'php:d.m.Y',
    'datetimeFormat'    => 'php:d.m.Y H:i:s',
    'thousandSeparator' => '',
    'timeZone'          => 'UTC',
]);

\Yii::$container->set('yii\behaviors\TimestampBehavior', [
    'value' => date('Y-m-d H:i:s'),
]);

\Yii::$container->set('yii\jui\DatePicker', [
    'dateFormat'    => 'yyyy-MM-dd',
    'clientOptions' => [
        'changeMonth' => true,
        'changeYear'  => true,
        'yearRange'   => '2016:' . date('Y'),
    ],
    'options'       => ['class' => 'form-control'],
]);

\Yii::$container->set('yii\grid\GridView', [
    'layout'    => "{pager}\n{summary}\n{items}",
    'emptyText' => 'Список пуст!',
    'pager'     => [
        'prevPageLabel'  => '<',
        'nextPageLabel'  => '>',
        'firstPageLabel' => '<<',
        'lastPageLabel'  => '>>',
    ],
]);

\Yii::$container->set('yiister\gentelella\widgets\grid\GridView', [
    'layout'    => "{pager}\n{summary}\n{items}",
    'emptyText' => 'Список пуст!',
    'pager'     => [
        'prevPageLabel'  => '<',
        'nextPageLabel'  => '>',
        'firstPageLabel' => '<<',
        'lastPageLabel'  => '>>',
    ],
]);

\Yii::$container->set('yii\widgets\ListView', [
    'layout' => "{pager}\n{summary}\n{items}",
]);

Yii::$container->set('kartik\grid\GridView', [
    'export'           => false,
    'resizableColumns' => false,
    'footerRowOptions' => ['class' => 'info text-bold'],
    'layout'           => "{pager}\n{summary}\n{items}",
    'pager'            => [
        'prevPageLabel'  => '<',
        'nextPageLabel'  => '>',
        'firstPageLabel' => '<<',
        'lastPageLabel'  => '>>',
    ],
]);

Yii::setAlias('@yiiBase', realpath(dirname(__FILE__) . '/../'));