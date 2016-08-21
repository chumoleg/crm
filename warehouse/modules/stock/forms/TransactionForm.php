<?php

namespace warehouse\modules\stock\forms;

use Yii;
use warehouse\models\transaction\Transaction;
use warehouse\models\transaction\TransactionProductComponent;
use common\components\base\Model;

class TransactionForm extends Transaction
{
    public $modelsProductComponent = [];

    public function saveCreateForm()
    {
        if (!$this->load(Yii::$app->request->post())) {
            return false;
        }

        $this->modelsProductComponent = Model::createMultiple(TransactionProductComponent::className());
        Model::loadMultiple($this->modelsProductComponent, Yii::$app->request->post());

        $valid = $this->validate();
        $valid = Model::validateMultiple($this->modelsProductComponent) && $valid;
        if (!$valid) {
            return false;
        }

        return $this->_saveModels();
    }

    /**
     * @param $deletedTransactionProductComponentsIDs
     *
     * @return bool
     */
    private function _saveModels($deletedTransactionProductComponentsIDs = [])
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($flag = $this->save()) {
                if (!empty($deletedTransactionProductComponentsIDs)) {
                    TransactionProductComponent::deleteAll(['id' => $deletedTransactionProductComponentsIDs]);
                }

                foreach ($this->modelsProductComponent as $index => $modelProductComponent) {
                    if ($flag === false) {
                        break;
                    }

                    $modelProductComponent->transaction_id = $this->id;
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