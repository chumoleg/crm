<?php

namespace warehouse\modules\nomenclature\controllers;

use Yii;
use common\models\techList\TechListProductComponent;
use common\models\techList\TechListSearch;
use warehouse\modules\nomenclature\forms\TechListForm;
use common\components\controllers\CrudController;

class TechListController extends CrudController
{
    protected function _getSearchClassName()
    {
        return TechListSearch::className();
    }

    protected function _getModelById($id)
    {
        return TechListForm::findById($id);
    }

    protected function _getFormClassName()
    {
        return TechListForm::className();
    }

    public function actionCreate()
    {
        $this->model = new TechListForm();
        $this->model->modelsProductComponent = [new TechListProductComponent()];

        if ($this->model->saveCreateForm()) {
            return $this->redirect(['index']);
        }

        return $this->_renderForm('create');
    }

    public function actionUpdate($id)
    {
        $this->loadModel($id);
        $this->model->modelsProductComponent = $this->model->techListProductComponents;

        if ($this->model->saveUpdateForm()) {
            return $this->redirect(['index']);
        }

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
            ? $this->model->modelsProductComponent : [new TechListProductComponent()];

        return $this->render($view);
    }
}