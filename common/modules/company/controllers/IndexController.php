<?php

namespace common\modules\company\controllers;

use Yii;
use common\models\user\User;
use common\components\helpers\JsonHelper;
use common\models\company\CompanyContact;
use common\modules\company\forms\CompanyForm;
use common\components\controllers\CrudController;
use common\models\company\CompanySearch;
use yii\web\ForbiddenHttpException;

class IndexController extends CrudController
{
    public function actionCreate()
    {
        $this->model = new CompanyForm();
        $this->model->contactData = [new CompanyContact()];

        if ($this->model->saveForm()) {
            return $this->redirect(['index']);
        }

        return $this->_renderForm('create');
    }

    public function actionUpdate($id)
    {
        $this->loadModel($id);
        $this->model->contactData = $this->model->companyContacts;

        if ($this->model->saveForm(true)) {
            return $this->redirect(['index']);
        }

        return $this->_renderForm('update');
    }

    protected function _getSearchClassName()
    {
        return CompanySearch::className();
    }

    protected function _getModelById($id)
    {
        $model = CompanyForm::findById($id);

        if (User::isOperator()) {
            if ($model->current_operator != Yii::$app->user->id) {
                throw new ForbiddenHttpException('Доступ запрещен');
            }
        }

        return $model;
    }

    protected function _getFormClassName()
    {
        return CompanyForm::className();
    }

    /**
     * @param $view
     *
     * @return string
     */
    protected function _renderForm($view)
    {
        $this->model->contactData = !empty($this->model->contactData)
            ? $this->model->contactData : [new CompanyContact()];

        return $this->render($view);
    }

    public function actionAddContact()
    {
        if (!Yii::$app->request->isAjax) {
            return false;
        }

        parse_str(Yii::$app->request->post('formData'), $formData);
        $counter = (int)Yii::$app->request->post('counter');

        $formClass = $this->_getFormClassName();
        $form = new $formClass;

        $model = new CompanyContact();
        $model->company_id = 1;
        if ($model->load($formData)) {
            return JsonHelper::answerSuccess(
                $this->renderPartial(
                    'partial/_contactRow',
                    [
                        'form'    => $form->getReflectionClassName(),
                        'model'   => $model,
                        'counter' => $counter,
                    ]
                )
            );
        }

        return $this->renderAjax('partial/_contactForm', ['model' => $model]);
    }
}
