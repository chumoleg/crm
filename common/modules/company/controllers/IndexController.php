<?php

namespace common\modules\company\controllers;

use common\components\Role;
use Yii;
use common\components\helpers\JsonHelper;
use common\models\company\CompanyContact;
use common\modules\company\forms\CompanyForm;
use common\components\controllers\CrudController;
use common\models\company\CompanySearch;
use yii\web\ForbiddenHttpException;

class IndexController extends CrudController
{
    protected function _getSearchClassName()
    {
        return CompanySearch::className();
    }

    protected function _getModelById($id)
    {
        $model = CompanyForm::findById($id);

        if (Yii::$app->user->can(Role::OPERATOR)) {
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
