<?php

namespace frontend\modules\report;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'frontend\modules\report\controllers';
    public $layout = '@app/views/layouts/report';

    public function init()
    {
        parent::init();
    }
}
