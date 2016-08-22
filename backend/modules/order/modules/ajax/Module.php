<?php

namespace backend\modules\order\modules\ajax;

use Yii;
use yii\web\BadRequestHttpException;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'backend\modules\order\modules\ajax\controllers';

    public function init()
    {
        if (!Yii::$app->request->isAjax) {
            throw new BadRequestHttpException('Некорректный запрос');
        }

        parent::init();
    }
}
