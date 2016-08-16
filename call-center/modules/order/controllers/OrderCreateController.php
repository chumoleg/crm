<?php

namespace frontend\modules\order\controllers;

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

    public function actionCreateByClient($clientId)
    {
        $formModelClass = $this->_getFormClassName();
        $this->model = new $formModelClass();
        $this->model->setScenario(CreateOrderForm::SCENARIO_BY_CLIENT);
        $this->model->clientId = $clientId;

        return $this->_renderAndSave('by-client');
    }

    private function _getFormClassName()
    {
        return CreateOrderForm::className();
    }

    private function _renderAndSave($view)
    {
        $post = Yii::$app->request->post();
        if ($this->model->load($post) && $this->model->save()) {
            if (!empty($this->model->clientId)) {
                return $this->redirect(['/order/client/view', 'id' => $this->model->clientId]);
            } else {
                return $this->redirect(['/order/order/index']);
            }

        } else {
            return $this->render($view);
        }
    }
}
