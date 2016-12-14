<?php

namespace common\modules\order;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'common\modules\order\controllers';
    public $layout = '@app/views/layouts/main';

    public $accessCreateOrder = true;

    public function init()
    {
        $this->modules = [
            'ajax' => [
                'class' => 'common\modules\order\modules\ajax\Module',
            ],
        ];

        parent::init();
    }
}
