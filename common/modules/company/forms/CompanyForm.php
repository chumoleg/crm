<?php

namespace common\modules\company\forms;

use Yii;
use common\models\company\Company;
use common\models\company\CompanyContact;
use yii\helpers\ArrayHelper;
use common\components\base\Model;

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
                [['name'], 'filter', 'filter' => 'trim'],
                [['name'], 'unique'],
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

    public function saveForm($update = false)
    {
        if (!$this->load(Yii::$app->request->post())) {
            return false;
        }

        $oldContactIds = [];
        if ($update) {
            $oldContactIds = ArrayHelper::map($this->contactData, 'id', 'id');
        }

        $this->contactData = Model::createMultiple(CompanyContact::className(), $this->contactData);
        Model::loadMultiple($this->contactData, Yii::$app->request->post());

        $valid = $this->validate();
        $valid = Model::validateMultiple($this->contactData) && $valid;

        if (!$valid) {
            return false;
        }

        $deletedContactIds = [];
        if ($update) {
            $deletedContactIds = array_diff($oldContactIds,
                array_filter(ArrayHelper::map($this->contactData, 'id', 'id')));
        }



        return $this->_saveModels($deletedContactIds);
    }

    /**
     * @param $deletedContactIds
     *
     * @return bool
     */
    private function _saveModels($deletedContactIds = [])
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($flag = $this->save()) {
                if (!empty($deletedContactIds)) {
                    CompanyContact::deleteAll(['id' => $deletedContactIds]);
                }

                foreach ($this->contactData as $index => $model) {
                    if ($flag === false) {
                        break;
                    }

                    $model->company_id = $this->id;
                    if (!($flag = $model->save())) {
                        break;
                    }
                }
            }

            if ($flag) {
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
}
