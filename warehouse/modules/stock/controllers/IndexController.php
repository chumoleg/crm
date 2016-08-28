<?php

namespace warehouse\modules\stock\controllers;

use warehouse\models\productComponent\ProductComponentStock;
use warehouse\models\transaction\Transaction;
use warehouse\models\transaction\TransactionProductComponent;
use warehouse\models\transaction\TransactionSearch;
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

        $modelTransaction = new TransactionSearch();
        $dataProviderTransaction = $modelTransaction->search(Yii::$app->request->get(), function ($q) use ($model) {
            $innerQuery = TransactionProductComponent::find()
                ->select('transaction_id')
                ->andWhere(['product_component_id' => $model->id]);

            $q->andWhere(['IN', 'id', $innerQuery]);
        });

        return $this->render('view', [
            'model'                   => $model,
            'modelTransaction'        => $modelTransaction,
            'dataProviderTransaction' => $dataProviderTransaction
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
        $relModel = ProductComponentStock::findById($id);
        if (empty($relModel)) {
            throw new NotFoundHttpException();
        }

        return $relModel->productComponent;
    }
}
