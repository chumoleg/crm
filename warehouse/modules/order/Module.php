<?php

namespace warehouse\modules\order;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'warehouse\modules\order\controllers';
    public $layout = '@app/views/layouts/main';

    public function init()
    {
        $this->modules = [
            'ajax' => [
                'class' => 'warehouse\modules\order\modules\ajax\Module',
            ],
        ];

        parent::init();
    }
}
