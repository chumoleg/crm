<?php

namespace backend\modules\management\modules\process\controllers;

use Yii;
use common\models\process\Process;
use common\components\controllers\CrudController;
use common\models\process\ProcessSearch;
use common\components\helpers\ArrayHelper;
use common\models\process\ProcessStage;
use common\models\process\ProcessStageAction;
use yii\web\NotFoundHttpException;
use backend\modules\management\modules\process\forms\ProcessForm;

class ProcessController extends CrudController
{
    public function actionCreate()
    {
        $this->model = new ProcessForm();
        $this->model->modelsStage = [new ProcessStage()];
        $this->model->modelsAction = [[new ProcessStageAction()]];

        if ($this->model->saveCreateForm()) {
            return $this->redirect(['index']);
        }

        return $this->_renderForm('create');
    }

    public function actionUpdate($id)
    {
        $this->loadModel($id);
        $this->model->modelsStage = $this->model->processStages;
        $this->model->modelsAction = [];

        if ($this->model->saveUpdateForm()) {
            return $this->redirect(['index']);
        }

        return $this->_renderForm('update');
    }

    public function actionDisable($id)
    {
        $model = $this->_getModel($id);
        $model->setDisabled();
        $model->save();
    }

    public function actionActivate($id)
    {
        $model = $this->_getModel($id);
        $model->setActive();
        $model->save();
    }

    protected function _getSearchClassName()
    {
        return ProcessSearch::className();
    }

    /**
     * @param $id
     *
     * @return null|ProcessForm
     * @throws NotFoundHttpException
     */
    protected function _getModelById($id)
    {
        $model = ProcessForm::findById($id);
        if (empty(Yii::$app->request->post())) {
            $model->sourceList = ArrayHelper::map($model->processSources, 'source_id', 'source_id');
        }

        return $model;
    }

    protected function _getFormClassName()
    {
        return ProcessForm::className();
    }

    /**
     * @param $view
     *
     * @return string
     */
    protected function _renderForm($view)
    {
        $this->model->modelsStage = !empty($this->model->modelsStage)
            ? $this->model->modelsStage : [new ProcessStage()];
        $this->model->modelsAction = !empty($this->model->modelsAction)
            ? $this->model->modelsAction : [[new ProcessStageAction()]];

        return $this->render($view);
    }

    /**
     * @param $id
     *
     * @return null|Process
     * @throws NotFoundHttpException
     */
    private function _getModel($id)
    {
        $model = Process::findById($id);
        if (empty($model)) {
            throw new NotFoundHttpException('Процесс не найден!');
        }

        return $model;
    }
}
