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

    public function actionAddCompanyContact()
    {
        $formData = Yii::$app->request->post('formData');
        parse_str($formData, $params);

        $model = new CompanyContact();
        $model->load($params);
        $model->save();

        return true;
    }
}
