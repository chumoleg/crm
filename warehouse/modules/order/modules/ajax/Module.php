<?php

namespace warehouse\modules\order\modules\ajax;

use Yii;
use yii\web\BadRequestHttpException;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'warehouse\modules\order\modules\ajax\controllers';

    public function init()
    {
        if (!Yii::$app->request->isAjax) {
            throw new BadRequestHttpException('Некорректный запрос');
        }

        parent::init();
    }
}
