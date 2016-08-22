<?php

namespace backend\modules\order;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'backend\modules\order\controllers';
    public $layout = '@app/views/layouts/main';

    public function init()
    {
        $this->modules = [
            'ajax' => [
                'class' => 'backend\modules\order\modules\ajax\Module',
            ],
        ];

        parent::init();
    }
}
