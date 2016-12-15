<?php

namespace backend\modules\common\forms;

use common\models\company\Company;
use common\models\company\CompanyContact;
use yii\helpers\ArrayHelper;

class CompanyForm extends Company
{
    public $contactData = [];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(
            [
                [['contactData'], 'safe'],
            ],
            parent::rules()
        );
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(),
            [
                'contactData' => 'Контакты организации',
            ]
        );
    }

    public function afterSave($insert, $changedAttributes)
    {
        $this->_saveContactData();

        parent::afterSave($insert, $changedAttributes);
    }

    private function _saveContactData()
    {
        CompanyContact::deleteAll(['company_id' => $this->id]);
        if (empty($this->contactData)) {
            return;
        }

        foreach ($this->contactData as $item) {
            $model = new CompanyContact();
            $model->attributes = $item;
            $model->company_id = $this->id;
            $model->save();
        }
    }
}
