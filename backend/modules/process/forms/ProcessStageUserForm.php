<?php

namespace backend\modules\management\modules\process\forms;

use Yii;
use common\components\helpers\ArrayHelper;
use common\models\process\Process;
use common\models\process\ProcessStage;
use common\models\process\ProcessStageOperator;
use common\models\stage\Stage;
use common\components\base\Model;

class ProcessStageUserForm extends Model
{
    public $processId;
    public $operatorList = [];
    public $typeSearchOperatorList = [];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['processId'], 'required'],
            [['operatorList', 'typeSearchOperatorList'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'operatorList'           => 'Операторы',
            'typeSearchOperatorList' => 'Тип выбора',
            'processId'              => 'Процесс',
        ];
    }

    public function saveForm()
    {
        if (!$this->load(Yii::$app->request->post())) {
            return false;
        }

        foreach ($this->operatorList as $stageId => $operators) {
            $process = Process::findById($this->processId);
            $stage = Stage::findById($stageId);

            $processStage = ProcessStage::findByProcessAndStage($process, $stage);
            $processStage->type_search_operator = ArrayHelper::getValue($this->typeSearchOperatorList, $stageId);
            $processStage->save();

            ProcessStageOperator::deleteAll(['process_id' => $this->processId, 'stage_id' => $stageId]);
            if (empty($operators)) {
                continue;
            }

            foreach ($operators as $operator) {
                $obj = new ProcessStageOperator();
                $obj->process_id = $this->processId;
                $obj->stage_id = $stageId;
                $obj->operator_id = $operator;
                $obj->save();
            }
        }

        return true;
    }

    public function fill(Process $process)
    {
        $this->processId = $process->id;

        foreach ($process->processStages as $processStage) {
            $fieldKey = $processStage->stage_id;

            $this->operatorList[$fieldKey] = ArrayHelper::getColumn($processStage->processStageOperators, 'operator_id');
            $this->typeSearchOperatorList[$fieldKey] = $processStage->type_search_operator;
        }
    }
}
