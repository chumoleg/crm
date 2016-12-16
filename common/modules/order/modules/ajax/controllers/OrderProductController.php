<?php

namespace common\modules\order\modules\ajax\controllers;

use Yii;
use common\components\helpers\JsonHelper;
use common\models\product\ProductPrice;
use common\models\order\OrderProduct;
use common\components\controllers\order\OrderManageController;

class OrderProductController extends OrderManageController
{
    public function init()
    {
        parent::init();
        $this->_checkAccess();
    }

    public function actionAdd()
    {
        $productPriceId = (int)Yii::$app->request->post('productPriceId');

        $productPriceModel = ProductPrice::findById($productPriceId);
        if (empty($productPriceModel)) {
            return JsonHelper::answerError('Выбранный товар или цена не найдены!');
        }

        $orderProduct = OrderProduct::createByProductPrice($this->model, $productPriceModel);
        if (!$orderProduct) {
            return JsonHelper::answerError('Ошибка при добавлении товара!');
        }

        $this->model->recalculatePrice();

        $commentText = 'Добавлен товар "' . $productPriceModel->product->name
            . '" (ID товара: ' . $productPriceModel->product_id
            . '; Цена: ' . $productPriceModel->price . ')';

        return $this->_returnAnswer($commentText);
    }

    public function actionRemove()
    {
        $orderProductId = (int)Yii::$app->request->post('orderProductId');

        $orderProduct = OrderProduct::findById($orderProductId);
        if (!$orderProduct) {
            return JsonHelper::answerError('Ошибка при удалении товара!');
        }

        $orderProduct->delete();
        $this->model->recalculatePrice();

        $commentText = 'Удален товар "' . $orderProduct->product->name
            . '" (ID товара: ' . $orderProduct->product_id
            . '; Цена: ' . $orderProduct->price . ')';

        return $this->_returnAnswer($commentText);
    }

    /**
     * @param $commentText
     *
     * @return array
     */
    private function _returnAnswer($commentText)
    {
        return JsonHelper::answerSuccess([
            'commentList' => $this->_addOrderComment($commentText),
            'productList' => $this->renderPartial('@common/modules/order/views/order/partial/_productsTable')
        ]);
    }
}