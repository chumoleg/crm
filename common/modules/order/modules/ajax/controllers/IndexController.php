<?php

namespace common\modules\order\modules\ajax\controllers;

use Yii;
use common\models\company\CompanyContact;
use common\models\order\Order;
use common\components\controllers\BaseController;
use common\models\product\ProductPrice;

class IndexController extends BaseController
{
    public function actionProductList($type)
    {
        $productPricesList = ProductPrice::findByType($type);
        if (empty($productPricesList)) {
            return 'Подходящих товаров не найдено!';
        }

        return $this->renderAjax('/order-manage/productList', ['productPricesList' => $productPricesList]);
    }

    public function actionContactForm($id)
    {
        $order = Order::findById($id);

        $model = new CompanyContact();
        $model->company_id = $order->company_customer;

        return $this->renderAjax('contactForm', ['model' => $model]);
    }

    public function actionChangePostponedFilter()
    {
        $key = Yii::$app->request->post('key');
        if (empty($key)) {
            return true;
        }

        $session = Yii::$app->session;

        $keyName = Order::POSTPONED_SESSION_KEY;
        $currentKey = $session->get($keyName);
        if ($currentKey == $key) {
            $session->set($keyName, null);
        } else {
            $session->set($keyName, $key);
        }

        return true;
    }
}
