<?php

namespace call\modules\order;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'call\modules\order\controllers';
    public $layout = '@app/views/layouts/main';

    public function init()
    {
        $this->modules = [
            'ajax' => [
                'class' => 'call\modules\order\modules\ajax\Module',
            ],
        ];

        parent::init();
    }
}
