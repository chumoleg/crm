<?php

namespace backend\modules\process\forms;

use common\models\stage\Stage;
use common\models\stage\StageMethod;
use yii\helpers\ArrayHelper;

class StageForm extends Stage
{
    public $methodData = [];

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'methodData' => 'Методы',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            ['methodData', 'safe']
        ]);
    }

    public function afterSave($insert, $changedAttributes)
    {
        $this->_saveMethodData();

        parent::afterSave($insert, $changedAttributes);
    }

    private function _saveMethodData()
    {
        StageMethod::deleteAll(['stage_id' => $this->id]);
        if (empty($this->methodData)) {
            return;
        }

        foreach ($this->methodData as $item) {
            StageMethod::addNewRow($this, $item);
        }
    }
}
