<?php

namespace warehouse\modules\nomenclature\forms;

use Yii;
use common\models\techList\TechListProductComponent;
use common\models\techList\TechList;
use common\components\helpers\ArrayHelper;
use common\components\base\Model;

class TechListForm extends TechList
{
    public $modelsProductComponent = [];

    public function saveCreateForm()
    {
        if (!$this->load(Yii::$app->request->post())) {
            return false;
        }

        $this->modelsProductComponent = Model::createMultiple(TechListProductComponent::className());
        Model::loadMultiple($this->modelsProductComponent, Yii::$app->request->post());

        $valid = $this->validate();
        $valid = Model::validateMultiple($this->modelsProductComponent) && $valid;
        if (!$valid) {
            return false;
        }

        return $this->_saveModels();
    }

    public function saveUpdateForm()
    {
        if (!$this->load(Yii::$app->request->post())) {
            return false;
        }

        $oldProductComponentsIDs = ArrayHelper::map($this->modelsProductComponent, 'id', 'id');

        $this->modelsProductComponent = Model::createMultiple(TechListProductComponent::className(),
            $this->modelsProductComponent);
        Model::loadMultiple($this->modelsProductComponent, Yii::$app->request->post());

        $deletedTechListProductComponentsIDs = array_diff($oldProductComponentsIDs,
            array_filter(ArrayHelper::map($this->modelsProductComponent, 'id', 'id')));

        $valid = $this->validate();
        $valid = Model::validateMultiple($this->modelsProductComponent) && $valid;
        if (!$valid) {
            return false;
        }

        return $this->_saveModels($deletedTechListProductComponentsIDs);
    }

    /**
     * @param $deletedTechListProductComponentsIDs
     *
     * @return bool
     */
    private function _saveModels($deletedTechListProductComponentsIDs = [])
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($flag = $this->save()) {
                if (!empty($deletedTechListProductComponentsIDs)) {
                    TechListProductComponent::deleteAll(['id' => $deletedTechListProductComponentsIDs]);
                }

                foreach ($this->modelsProductComponent as $index => $modelProductComponent) {
                    if ($flag === false) {
                        break;
                    }

                    $modelProductComponent->tech_list_id = $this->id;
                    if (!($flag = $modelProductComponent->save())) {
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
