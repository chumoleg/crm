<?php

namespace common\components\controllers;

use Yii;
use yii\web\NotFoundHttpException;

abstract class CrudController extends BaseController
{
    public $model;
    public $useScenarios = false;
    public $redirect = ['index'];

    public function actionIndex()
    {
        $model = $this->_getSearchClassName();

        $searchModel = new $model();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param int $id
     *
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $this->loadModel($id);

        return $this->render('view');
    }

    /**
     * @param int $id
     *
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $this->loadModel($id);
        if ($this->useScenarios) {
            $this->model->setScenario('update');
        }

        $post = $this->_getPostParams();

        if ($this->model->load($post) && $this->model->save()) {
            return $this->redirect($this->redirect);
        } else {
            return $this->render('update');
        }
    }

    /**
     * @param int $id
     *
     * @throws NotFoundHttpException
     */
    public function loadModel($id)
    {
        $this->model = $this->_getModelById($id);
        if (empty($this->model)) {
            throw new NotFoundHttpException('Не найдено объекта с указанным ID!');
        }
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $formModelClass = $this->_getFormClassName();
        $this->model = new $formModelClass();
        if ($this->useScenarios) {
            $this->model->setScenario('create');
        }

        $post = $this->_getPostParams();
        if ($this->model->load($post) && $this->model->save()) {
            return $this->redirect($this->redirect);
        } else {
            return $this->render('create');
        }
    }

    public function actionDelete($id)
    {
        $this->loadModel($id);
        $this->model->delete();

        return $this->redirect($this->redirect);
    }

    abstract protected function _getSearchClassName();

    abstract protected function _getModelById($id);

    abstract protected function _getFormClassName();

    protected function _getPostParams()
    {
        return Yii::$app->request->post();
    }
}