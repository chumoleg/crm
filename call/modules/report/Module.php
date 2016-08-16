<?php

namespace call\modules\report;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'call\modules\report\controllers';
    public $layout = '@app/views/layouts/report';

    public function init()
    {
        parent::init();
    }
}
