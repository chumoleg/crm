<?php

namespace backend\modules\management\modules\process\forms;

use Yii;
use common\models\process\Process;
use common\components\Status;
use common\components\helpers\ArrayHelper;
use common\models\process\ProcessSource;
use common\models\process\ProcessStage;
use common\models\process\ProcessStageAction;
use common\components\base\Model;
use common\models\stage\Stage;

class ProcessForm extends Process
{
    public $sourceList;
    public $modelsStage = [];
    public $modelsAction = [];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge([
            [['sourceList'], 'required'],
        ], parent::rules());
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge([
            'sourceList' => 'Источники',
        ], parent::attributeLabels());
    }

    public function beforeSave($insert)
    {
        $this->status = Status::STATUS_ACTIVE;

        return parent::beforeSave($insert);
    }

    public function saveCreateForm()
    {
        if (!$this->load(Yii::$app->request->post())) {
            return false;
        }

        $this->modelsStage = Model::createMultiple(ProcessStage::className());
        Model::loadMultiple($this->modelsStage, Yii::$app->request->post());

        $valid = $this->validate();
        $valid = Model::validateMultiple($this->modelsStage) && $valid;

        $postActionName = (new ProcessStageAction())->getReflectionClassName();
        if (isset($_POST[$postActionName][0][0])) {
            foreach ($_POST[$postActionName] as $indexStage => $actionsForSave) {
                foreach ($actionsForSave as $indexAction => $action) {
                    $data[$postActionName] = $action;

                    $modelAction = new ProcessStageAction();
                    $modelAction->load($data);

                    $this->modelsAction[$indexStage][$indexAction] = $modelAction;
                    $valid = $modelAction->validate();
                }
            }
        }

        if (!$valid) {
            return false;
        }

        return $this->_saveModels();
    }

    public function saveUpdateForm()
    {
        $oldActions = [];
        if (!empty($this->modelsStage)) {
            foreach ($this->modelsStage as $indexStage => $modelStage) {
                $actions = $modelStage->actions;
                foreach ($actions as $action) {
                    $action->reasonData = ArrayHelper::getColumn($action->processStageActionReasons, 'reason_id');
                }

                $this->modelsAction[$indexStage] = $actions;

                $oldActions = ArrayHelper::merge(ArrayHelper::index($actions, 'id'), $oldActions);
            }
        }

        if (!$this->load(Yii::$app->request->post())) {
            return false;
        }

        $oldStageIDs = ArrayHelper::map($this->modelsStage, 'id', 'id');

        $this->modelsAction = [];
        $this->modelsStage = Model::createMultiple(ProcessStage::className(), $this->modelsStage);
        Model::loadMultiple($this->modelsStage, Yii::$app->request->post());

        $deletedProcessStageIDs = array_diff($oldStageIDs,
            array_filter(ArrayHelper::map($this->modelsStage, 'id', 'id')));

        $valid = $this->validate();
        $valid = Model::validateMultiple($this->modelsStage) && $valid;

        $postActionName = (new ProcessStageAction())->getReflectionClassName();
        $actionsIDs = [];
        if (isset($_POST[$postActionName][0][0])) {
            foreach ($_POST[$postActionName] as $indexStage => $actions) {
                $actionsIDs = ArrayHelper::merge($actionsIDs, array_filter(ArrayHelper::getColumn($actions, 'id')));
                foreach ($actions as $indexAction => $action) {
                    $data[$postActionName] = $action;

                    $modelAction = (isset($action['id']) && isset($oldActions[$action['id']]))
                        ? $oldActions[$action['id']] : new ProcessStageAction();
                    $modelAction->load($data);

                    $this->modelsAction[$indexStage][$indexAction] = $modelAction;

                    $valid = $modelAction->validate();
                }
            }
        }

        if (!$valid) {
            return false;
        }

        $oldActionsIDs = ArrayHelper::getColumn($oldActions, 'id');
        $deletedActionsIDs = array_diff($oldActionsIDs, $actionsIDs);

        return $this->_saveModels($deletedActionsIDs, $deletedProcessStageIDs);
    }

    public function afterSave($insert, $changedAttributes)
    {
        $this->_saveSources();

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @param $deletedActionsIDs
     * @param $deletedProcessStageIDs
     *
     * @return bool
     */
    private function _saveModels($deletedActionsIDs = [], $deletedProcessStageIDs = [])
    {
        $actionsForSave = [];
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($flag = $this->save()) {
                if (!empty($deletedActionsIDs)) {
                    ProcessStageAction::deleteAll(['id' => $deletedActionsIDs]);
                }

                if (!empty($deletedProcessStageIDs)) {
                    ProcessStage::deleteAll(['id' => $deletedProcessStageIDs]);
                }

                foreach ($this->modelsStage as $indexStage => $modelStage) {
                    if ($flag === false) {
                        break;
                    }

                    $modelStage->process_id = $this->id;
                    if (!($flag = $modelStage->save())) {
                        break;
                    }

                    if (!isset($this->modelsAction[$indexStage]) || !is_array($this->modelsAction[$indexStage])) {
                        continue;
                    }

                    foreach ($this->modelsAction[$indexStage] as $indexAction => $modelAction) {
                        $modelAction->process_stage_id = $modelStage->id;
                        $actionsForSave[] = $modelAction;
                    }
                }
            }

            if ($flag) {
                foreach ($actionsForSave as $actionModel) {
                    if (empty($actionModel->action_id)) {
                        continue;
                    }

                    $stage = Stage::findById($actionModel->follow_to_stage_id);
                    if (!empty($stage)) {
                        $processStage = ProcessStage::findByProcessAndStage($this, $stage);
                        $actionModel->follow_to_stage_id = !empty($processStage) ? $processStage->stage_id : null;
                    }

                    $actionModel->save();
                    print_r($actionModel->errors);
                }

                $transaction->commit();
                return true;

            } else {
                $transaction->rollBack();
            }

        } catch (\Exception $e) {
            $transaction->rollBack();
        }

        return false;
    }

    private function _saveSources()
    {
        ProcessSource::deleteAll(['process_id' => $this->id]);
        foreach ($this->sourceList as $item) {
            ProcessSource::addNewRow($this, $item);
        }
    }
}
