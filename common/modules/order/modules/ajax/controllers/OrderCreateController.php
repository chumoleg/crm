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
        $quantity = (int)Yii::$app->request->post('quantity', 1);
        $productPriceId = (int)Yii::$app->request->post('productPriceId');
        if (empty($quantity) || $quantity < 0) {
            return JsonHelper::answerError('Кол-во указано неверно');
        }

        $model = ProductPrice::findById($productPriceId);
        if (empty($model)) {
            return 'Ошибка при добавлении товара!';
        }

        $formClass = $this->_getFormClassName();
        $form = new $formClass;

        $html = $this->renderPartial('productRow', [
            'form'     => $form->getReflectionClassName(),
            'model'    => $model,
            'counter'  => $counter,
            'quantity' => $quantity
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
            'form'  => $form->getReflectionClassName(),
            'model' => $model,
        ]);

        return JsonHelper::answerSuccess($html);
    }

    private function _getFormClassName()
    {
        return CreateOrderForm::className();
    }
}
