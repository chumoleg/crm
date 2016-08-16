<?php

namespace backend\modules\management\modules\common;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'backend\modules\management\modules\common\controllers';

    public function getMenuItems()
    {
        $url = \Yii::$app->request->url;

        return [
            [
                'label'  => 'Пользователи',
                'url'    => ['/management/common/user/index'],
                'active' => (bool)strstr($url, 'management/common/user/')
            ],
            [
                'label'  => 'Товары',
                'url'    => ['/management/common/product/index'],
                'active' => (bool)strstr($url, 'management/common/product/')
            ],
            [
                'label'  => 'Источники',
                'url'    => ['/management/common/source/index'],
                'active' => (bool)strstr($url, 'management/common/source/')
            ],
            [
                'label'  => 'Теги',
                'url'    => ['/management/common/tag/index'],
                'active' => (bool)strstr($url, 'management/common/tag/')
            ],
        ];
    }
}