<?php

namespace common\modules\order\controllers;

use Yii;
use common\components\controllers\BaseController;
use common\forms\CreateOrderForm;

class OrderCreateController extends BaseController
{
    public $model;

    public function actionIndex()
    {
        $formModelClass = $this->_getFormClassName();
        $this->model = new $formModelClass();
        $this->model->setScenario(CreateOrderForm::SCENARIO_BY_PARAMS);

        return $this->_renderAndSave('index');
    }

    private function _getFormClassName()
    {
        return CreateOrderForm::className();
    }

    private function _renderAndSave($view)
    {
        $post = Yii::$app->request->post();
        if ($this->model->load($post) && $this->model->save()) {
            return $this->redirect(['my-order/index']);

        } else {
            return $this->render($view);
        }
    }
}
