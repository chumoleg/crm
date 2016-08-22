<?php

namespace warehouse\modules\stock\controllers;

use Yii;
use warehouse\models\productComponent\ProductComponentStockSearch;
use warehouse\models\productComponent\ProductComponent;
use common\components\controllers\BaseController;
use yii\web\NotFoundHttpException;

class IndexController extends BaseController
{
    public function actionIndex()
    {
        $searchModel = new ProductComponentStockSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionView($id)
    {
        $model = $this->_loadModel($id);

        return $this->render('view', [
            'model' => $model
        ]);
    }

    /**
     * @param $id
     *
     * @return null|ProductComponent
     * @throws NotFoundHttpException
     */
    private function _loadModel($id)
    {
        $model = ProductComponent::findById($id);
        if (empty($model)) {
            throw new NotFoundHttpException();
        }

        return $model;
    }
}
