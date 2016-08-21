<?php

namespace common\components\controllers\order;

use Yii;
use common\models\system\SystemUrl;
use common\components\Status;
use common\models\reason\Reason;
use common\models\action\Action;
use common\models\process\ProcessStage;
use common\components\helpers\JsonHelper;
use common\models\order\OrderStage;
use common\models\process\ProcessStageAction;

class OrderStatusController extends OrderManageController
{
    /**
     * @var Action
     */
    private $_actionModel;

    public function init()
    {
        parent::init();

        $this->_actionModel = Action::findById((int)Yii::$app->request->post('action'));
        if (empty($this->_actionModel)) {
            JsonHelper::answerError('Такое действие не найдено!');
        }

        $this->_checkAccess();
    }

    public function actionAction()
    {
        $processStageAction = $this->_getProcessStageAction();
        $actionReasons = $processStageAction->processStageActionReasons;

        if ($this->_actionModel->hold == Status::STATUS_ACTIVE) {
            $html = $this->renderAjax('holdForm', ['action' => $this->_actionModel, 'actionReasons' => $actionReasons]);

            return JsonHelper::answerSuccess([
                'reload' => false,
                'modal'  => [
                    'body'  => $html,
                    'title' => 'Перенос звонка'
                ]
            ]);
        }

        if (!empty($actionReasons)) {
            $html = $this->renderAjax('reasons', ['action' => $this->_actionModel, 'actionReasons' => $actionReasons]);

            return JsonHelper::answerSuccess([
                'reload' => false,
                'modal'  => [
                    'body'  => $html,
                    'title' => 'Выберите причину'
                ]
            ]);
        }

        return $this->_changeStatus($processStageAction);
    }

    public function actionChange()
    {
        $processStageAction = $this->_getProcessStageAction();

        return $this->_changeStatus($processStageAction);
    }

    /**
     * @param ProcessStageAction $processStageAction
     *
     * @return array
     */
    private function _changeStatus($processStageAction)
    {
        $this->model->client->setIsNotNew();

        $reasonModel = Reason::findById(Yii::$app->request->post('reason'));
        $actionComment = 'Действие: ' . $this->_actionModel->name;
        if (!empty($reasonModel)) {
            $actionComment .= '. Причина: ' . $reasonModel->name;
        }

        $commentList = $this->_addOrderComment($actionComment);

        if ($this->_actionModel->hold == Status::STATUS_ACTIVE) {
            $this->model->time_postponed = Yii::$app->request->post('holdTime');
            $commentList = $this->_addOrderComment('Заказ отложен до: '
                . Yii::$app->formatter->asDatetime($this->model->time_postponed));
        }

        $this->model->save();

        $currentOrderStage = $this->model->currentOrderStage;
        if (!empty($reasonModel)) {
            $currentOrderStage->reason_id = $reasonModel->id;
        }

        $currentOrderStage->action_id = $this->_actionModel->id;

        $followToStage = $processStageAction->followToStage;
        if (!empty($followToStage)) {
            $processStage = ProcessStage::findByProcessAndStage($this->model->process, $followToStage);
            if (!empty($processStage)) {
                $currentOrderStage->setDisabled();

                OrderStage::addStageRow($this->model, $processStage);

                $commentList = $this->_addOrderComment('Статус изменен на: ' . $followToStage->name);

                $this->model->setOrderOperator();

                $this->_sendRequestToForeignSystem($followToStage);

                if (method_exists($this, '_writeProductComponents')) {
                    $this->_writeProductComponents();
                }
            }
        }

        $currentOrderStage->save();

        return $this->_returnAnswer($commentList);
    }

    /**
     * @return ProcessStageAction|null
     */
    private function _getProcessStageAction()
    {
        $currentStage = $this->model->currentStage;
        if (empty($currentStage)) {
            JsonHelper::answerError('Процесс обработки настроен некорректно!');
        }

        $processStageAction = ProcessStageAction::findByProcessStageAndAction(
            $this->model->getProcessStage(), $this->_actionModel);

        if (empty($processStageAction)) {
            JsonHelper::answerSuccess(['reload' => true]);
        }

        return $processStageAction;
    }

    private function _returnAnswer($commentList = null, $modalHtml = null, $reload = true)
    {
        return JsonHelper::answerSuccess([
            'reload'      => $reload,
            'commentList' => $commentList,
            'modalHtml'   => $modalHtml
        ]);
    }

    /**
     * @param $followToStage
     */
    private function _sendRequestToForeignSystem($followToStage)
    {
        $sourceSystems = $this->model->source->sourceSystems;
        if (empty($sourceSystems)) {
            return;
        }

        foreach ($sourceSystems as $sourceSystem) {
            $system = $sourceSystem->system;
            $systemUrl = $system->getSystemUrlByType(SystemUrl::TYPE_UPDATE_STATUS);
            if (empty($systemUrl)) {
                continue;
            }

            $systemStage = $system->getSystemStageByStage($followToStage->id);
            if (empty($systemStage)) {
                continue;
            }

            $params = [
                'order_id' => $this->model->id,
                'status'   => $systemStage->foreign_status
            ];

            $curl = Yii::$app->curl;
            $response = $curl
                ->setOption(CURLOPT_POSTFIELDS, http_build_query($params))
                ->post($systemUrl->url);
        }
    }
}