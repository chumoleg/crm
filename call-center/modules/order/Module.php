<?php

namespace frontend\modules\order;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'frontend\modules\order\controllers';
    public $layout = '@app/views/layouts/main';

    public function init()
    {
        $this->modules = [
            'ajax' => [
                'class' => 'frontend\modules\order\modules\ajax\Module',
            ],
        ];

        parent::init();
    }
}
