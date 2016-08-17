<?php

namespace warehouse\modules\nomenclature\controllers;

use Yii;
use common\components\controllers\CrudController;
use common\models\product\ProductSearch;
use common\models\product\ProductPrice;
use common\components\helpers\JsonHelper;
use warehouse\modules\nomenclature\forms\ProductForm;

class ProductController extends CrudController
{
    public function actionAddPrice()
    {
        if (!Yii::$app->request->isAjax) {
            return false;
        }

        parse_str(Yii::$app->request->post('formData'), $formData);
        $counter = (int)Yii::$app->request->post('counter');

        $formClass = $this->_getFormClassName();
        $form = new $formClass;

        $model = new ProductPrice();
        $model->product_id = 1;
        if ($model->load($formData)) {
            return JsonHelper::answerSuccess($this->renderPartial('partial/_priceRow', [
                'form'    => $form->getReflectionClassName(),
                'model'   => $model,
                'counter' => $counter
            ]));
        }

        return $this->renderAjax('partial/_priceForm', ['model' => $model]);
    }

    protected function _getSearchClassName()
    {
        return ProductSearch::className();
    }

    protected function _getModelById($id)
    {
        return ProductForm::findById($id);
    }

    protected function _getFormClassName()
    {
        return ProductForm::className();
    }
}
