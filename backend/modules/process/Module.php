<?php

namespace backend\modules\management\modules\process;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'backend\modules\management\modules\process\controllers';

    public function getMenuItems()
    {
        $url = \Yii::$app->request->url;

        return [
            [
                'label'  => 'Действия',
                'url'    => ['/management/process/action/index'],
                'active' => (bool)strstr($url, 'management/process/action/')
            ],
            [
                'label'  => 'Причины для действий',
                'url'    => ['/management/process/reason/index'],
                'active' => (bool)strstr($url, 'management/process/reason/')
            ],
            [
                'label'  => 'Статусы заказов',
                'url'    => ['/management/process/stage/index'],
                'active' => (bool)strstr($url, 'management/process/stage/')
            ],
            [
                'label'  => 'Процессы обработки заказов',
                'url'    => ['/management/process/process/index'],
                'active' => (bool)strstr($url, 'management/process/process')
            ],
        ];
    }
}
