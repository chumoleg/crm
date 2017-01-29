<?php

namespace backend\modules\common\forms;

use common\components\Status;
use common\models\source\Source;
use common\components\helpers\ArrayHelper;
use common\models\source\SourceSystem;

class SourceForm extends Source
{
    public $systemData = [];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge([
            [['systemData'], 'safe'],
        ], parent::rules());
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'systemData' => 'Системы',
        ]);
    }

    public function afterSave($insert, $changedAttributes)
    {
        $this->_saveSystemData();
        if ($this->is_default == Status::STATUS_ACTIVE) {
            $this->updateAll(['is_default' => Status::STATUS_NOT_ACTIVE], 'id != ' . $this->id);
        }

        parent::afterSave($insert, $changedAttributes);
    }

    private function _saveSystemData()
    {
        SourceSystem::deleteAll(['source_id' => $this->id]);
        if (empty($this->systemData)) {
            return;
        }

        foreach ($this->systemData as $system) {
            $model = new SourceSystem();
            $model->source_id = $this->id;
            $model->system_id = $system;
            $model->save();
        }
    }
}
