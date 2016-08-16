<?php

namespace call\modules\order\modules\ajax\controllers;

use Yii;
use common\components\controllers\BaseController;
use common\components\helpers\JsonHelper;
use common\models\geo\GeoArea;
use common\models\product\ProductPrice;

class IndexController extends BaseController
{
    public function actionAreaList()
    {
        $regionId = (int)Yii::$app->request->post('region');
        $areas = GeoArea::getListByRegion($regionId);
        $areas[0] = '...';
        ksort($areas);

        return JsonHelper::answerSuccess($areas);
    }

    public function actionProductList($type)
    {
        $productPricesList = ProductPrice::findByType($type);
        if (empty($productPricesList)) {
            return 'Подходящих товаров не найдено!';
        }

        return $this->renderAjax('/order-manage/productList', ['productPricesList' => $productPricesList]);
    }
}
