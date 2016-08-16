<?php

namespace call\modules\clientBase\controllers;

use Yii;
use common\models\clientBaseFile\ClientBaseFile;
use common\models\clientBaseFile\ClientBaseFileSearch;
use common\components\controllers\CrudController;
use call\modules\clientBase\forms\OrderLoadForm;
use yii\web\UploadedFile;

class FileController extends CrudController
{
    public function actionCreate()
    {
        $formClass = $this->_getFormClassName();
        $model = new $formClass();

        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->upload()) {
                Yii::$app->getSession()->setFlash('success', 'Файл успешно загружен. Запущен импорт данных');
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', ['model' => $model]);
    }

    protected function _getSearchClassName()
    {
        return ClientBaseFileSearch::className();
    }

    protected function _getModelById($id)
    {
        return ClientBaseFile::findById($id);
    }

    protected function _getFormClassName()
    {
        return OrderLoadForm::className();
    }
}
