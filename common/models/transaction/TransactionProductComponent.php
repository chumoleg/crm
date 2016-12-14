<?php

namespace common\models\transaction;

use Yii;
use common\components\base\ActiveRecord;
use common\components\Status;
use common\models\productComponent\ProductComponent;
use common\models\productComponent\ProductComponentStock;

/**
 * This is the model class for table "wh_transaction_product_component".
 *
 * @property integer          $id
 * @property integer          $transaction_id
 * @property integer          $product_component_id
 * @property integer          $quantity
 * @property string           $date_create
 *
 * @property ProductComponent $productComponent
 * @property Transaction      $transaction
 */
class TransactionProductComponent extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wh_transaction_product_component';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_component_id', 'quantity'], 'required'],
            [['transaction_id', 'product_component_id', 'quantity'], 'integer'],
            [['date_create'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                   => 'ID',
            'transaction_id'       => 'Transaction ID',
            'product_component_id' => 'Product Component ID',
            'quantity'             => 'Quantity',
            'date_create'          => 'Date Create',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductComponent()
    {
        return $this->hasOne(ProductComponent::className(), ['id' => 'product_component_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransaction()
    {
        return $this->hasOne(Transaction::className(), ['id' => 'transaction_id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        $transaction = Yii::$app->db->beginTransaction('SERIALIZABLE');
        try {
            $this->_updateCurrentStock();
            $transaction->commit();

        } catch (\Exception $e) {
            $transaction->rollBack();
        }

        return parent::afterSave($insert, $changedAttributes);
    }

    private function _updateCurrentStock()
    {
        /** @var ProductComponentStock $currentProductComponentStock */
        $currentProductComponentStock = ProductComponentStock::find()
            ->andWhere(['product_component_id' => $this->product_component_id])
            ->andWhere(['status' => Status::STATUS_ACTIVE])
            ->one();

        $currentQuantity = 0;
        if (!empty($currentProductComponentStock)) {
            $currentQuantity = $currentProductComponentStock->quantity;

            $currentProductComponentStock->setDisabled();
            $currentProductComponentStock->save();
        }

        if ($this->transaction->type == Transaction::TYPE_INCOME) {
            $quantity = $currentQuantity + $this->quantity;
        } else {
            $quantity = $currentQuantity - $this->quantity;
        }

        if ($quantity <= 0) {
            $quantity = 0;
        }

        $model = new ProductComponentStock();
        $model->product_component_id = $this->product_component_id;
        $model->quantity = $quantity;
        $model->status = Status::STATUS_ACTIVE;
        $model->date_update = date('Y-m-d H:i:s');
        $model->save();
    }
}
