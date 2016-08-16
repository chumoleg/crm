<?php

namespace backend\modules\management\modules\process\controllers;

use Yii;
use backend\modules\management\modules\process\forms\ProcessStageUserForm;
use common\components\controllers\BaseController;
use common\models\process\Process;
use yii\web\NotFoundHttpException;

class ProcessUserController extends BaseController
{
    public function actionIndex($id)
    {
        $process = $this->_getProcessModel($id);

        $model = new ProcessStageUserForm();
        $model->fill($process);

        if (!empty(Yii::$app->request->post())) {
            if ($model->saveForm()) {
                return $this->redirect(['management/process/index']);
            }
        }

        return $this->render('index', [
            'model'   => $model,
            'process' => $process
        ]);
    }

    /**
     * @param $id
     *
     * @return null|Process
     * @throws NotFoundHttpException
     */
    private function _getProcessModel($id)
    {
        $model = Process::findById($id);
        if (empty($model)) {
            throw new NotFoundHttpException('Процесс не найден!');
        }

        return $model;
    }
}
