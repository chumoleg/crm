<?php

namespace backend\modules\common;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'backend\modules\common\controllers';
    public $layout = '@app/views/layouts/manageTabs';

    public function getMenuItems()
    {
        $url = \Yii::$app->request->url;

        return [
            [
                'label'  => 'Пользователи',
                'url'    => ['/common/user/index'],
                'active' => (bool)strstr($url, 'common/user/')
            ],
            [
                'label'  => 'Источники',
                'url'    => ['/common/source/index'],
                'active' => (bool)strstr($url, 'common/source/')
            ],
        ];
    }
}