<?php

namespace backend\modules\process;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'backend\modules\process\controllers';

    public function getMenuItems()
    {
        $url = \Yii::$app->request->url;

        return [
            [
                'label'  => 'Действия',
                'url'    => ['/process/action/index'],
                'active' => (bool)strstr($url, 'process/action/')
            ],
            [
                'label'  => 'Причины для действий',
                'url'    => ['/process/reason/index'],
                'active' => (bool)strstr($url, 'process/reason/')
            ],
            [
                'label'  => 'Статусы заказов',
                'url'    => ['/process/stage/index'],
                'active' => (bool)strstr($url, 'process/stage/')
            ],
            [
                'label'  => 'Процессы обработки заказов',
                'url'    => ['/process/process/index'],
                'active' => (bool)strstr($url, 'process/process')
            ],
        ];
    }
}
