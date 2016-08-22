<?php

namespace warehouse\modules\stock\controllers;

use common\components\controllers\CrudController;
use warehouse\models\transaction\TransactionProductComponent;
use warehouse\models\transaction\TransactionSearch;
use warehouse\modules\stock\forms\TransactionForm;

class TransactionController extends CrudController
{
    protected function _getSearchClassName()
    {
        return TransactionSearch::className();
    }

    protected function _getModelById($id)
    {
        return TransactionForm::findById($id);
    }

    protected function _getFormClassName()
    {
        return TransactionForm::className();
    }

    public function actionCreate()
    {
        $this->model = new TransactionForm();
        $this->model->modelsProductComponent = [new TransactionProductComponent()];

        if ($this->model->saveCreateForm()) {
            return $this->redirect(['index']);
        }

        return $this->_renderForm('create');
    }

    public function actionUpdate($id)
    {
        $this->loadModel($id);
        $this->model->modelsProductComponent = $this->model->transactionProductComponents;

        return $this->_renderForm('update');
    }

    /**
     * @param $view
     *
     * @return string
     */
    protected function _renderForm($view)
    {
        $this->model->modelsProductComponent = !empty($this->model->modelsProductComponent)
            ? $this->model->modelsProductComponent : [new TransactionProductComponent()];

        return $this->render($view);
    }
}
