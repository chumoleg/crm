<?php

namespace common\modules\order\modules\ajax\controllers;

use Yii;
use common\components\helpers\JsonHelper;
use common\forms\CreateOrderForm;
use common\components\controllers\BaseController;
use common\models\product\ProductPrice;

class OrderCreateController extends BaseController
{
    public function actionAddProduct()
    {
        $counter = (int)Yii::$app->request->post('counter');
        $productPriceId = (int)Yii::$app->request->post('productPriceId');

        $model = ProductPrice::findById($productPriceId);
        if (empty($model)) {
            return 'Ошибка при добавлении товара!';
        }

        $formClass = $this->_getFormClassName();
        $form = new $formClass;

        $html = $this->renderPartial('productRow', [
            'form'    => $form->getReflectionClassName(),
            'model'   => $model,
            'counter' => $counter
        ]);

        return JsonHelper::answerSuccess($html);
    }

    public function actionAddContact()
    {
        $productPriceId = (int)Yii::$app->request->post('productPriceId');

        $model = ProductPrice::findById($productPriceId);
        if (empty($model)) {
            return 'Ошибка при добавлении товара!';
        }

        $formClass = $this->_getFormClassName();
        $form = new $formClass;

        $html = $this->renderPartial('productRow', [
            'form'    => $form->getReflectionClassName(),
            'model'   => $model,
        ]);

        return JsonHelper::answerSuccess($html);
    }

    private function _getFormClassName()
    {
        return CreateOrderForm::className();
    }
}
