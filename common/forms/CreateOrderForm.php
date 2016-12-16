<?php

namespace common\forms;

use Yii;
use common\models\order\OrderProduct;
use common\models\process\Process;
use common\models\order\Order;
use common\components\helpers\ArrayHelper;
use common\components\nomenclature\Currency;
use common\models\product\Product;
use common\models\source\Source;
use common\components\Role;

class CreateOrderForm extends Order
{
    const SCENARIO_BY_PARAMS = 'createByParams';
    const SCENARIO_BY_API = 'createByApi';

    public $source;
    public $company;

    public $product_data_checker;
    public $product_data = [];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(
            [
                [['company'], 'required'],
                [['source', 'company'], 'integer'],
                [['product_data'], 'required', 'on' => self::SCENARIO_BY_API],
                [['product_data_checker'], 'required', 'on' => self::SCENARIO_BY_PARAMS],
                [['product_data'], 'safe'],
                ['product_data', 'validateProductData', 'on' => self::SCENARIO_BY_API],
                ['product_data_checker', 'validateProductData', 'on' => self::SCENARIO_BY_PARAMS],
            ],
            parent::rules()
        );
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(
            [
                'source'               => 'Источник',
                'company'              => 'Организация',
                'product_data'         => 'Товары',
                'product_data_checker' => 'Товары',
            ],
            parent::attributeLabels()
        );
    }

    public function beforeValidate()
    {
        if (!empty($this->product_data)) {
            $this->product_data_checker = true;
        }

        return parent::beforeValidate();
    }

    public function validateProductData($attribute)
    {
        foreach ($this->product_data as $k => $item) {
            $productId = (int)ArrayHelper::getValue($item, 'product_id');
            if (empty($productId)) {
                $this->addError($attribute, 'Список товаров (позиция ' . $k . '): не указан ID товара');
            }

            $check = Product::findById($productId);
            if (empty($check)) {
                $this->addError($attribute, 'Список товаров (позиция ' . $k . '): товар не найден');
            }

            if (!isset($item['price'])) {
                $this->addError($attribute, 'Список товаров (позиция ' . $k . '): не указана цена товара');
            }
        }
    }

    public function beforeSave($insert)
    {
        $this->company_id = $this->company;

        $this->_setSourceId();
        $this->_setProcessId();

        $this->price = array_sum(array_column($this->product_data, 'price'));
        $this->currency = Currency::RUR;
        $this->create_user_id = $this->scenario == self::SCENARIO_BY_PARAMS ? Yii::$app->user->id : null;

        if (!empty(Yii::$app->user->id) && Yii::$app->user->can(Role::OPERATOR)) {
            $this->current_user_id = Yii::$app->user->id;
        }

        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        $this->_saveProducts();
        $this->saveFirstOrderStage();
        if (empty($this->current_user_id)) {
            $this->setOrderOperator();
        }

        parent::afterSave($insert, $changedAttributes);
    }

    public function fields()
    {
//        $post = [
//            'source'       => 'Источник',
//            'company'      => 'Организация',
//            'product_data' => [
//                [
//                    'product_id' => 'ID товара',
//                    'price'      => 'Цена товара',
//                ]
//            ],
//        ];

        $fields = ['id'];

        return array_combine($fields, $fields);
    }

    private function _saveProducts()
    {
        foreach ($this->product_data as $item) {
            OrderProduct::addByParams(
                $this,
                $item['product_id'],
                $item['price'],
                ArrayHelper::getValue($item, 'quantity', 1),
                $this->currency
            );
        }
    }

    private function _setProcessId()
    {
        $process = Process::findProcessBySource($this->source_id);
        $this->process_id = ArrayHelper::getValue($process, 'id');
    }

    private function _setSourceId()
    {
        $this->source_id = $this->source;

        $checkSource = Source::findById($this->source);
        if (!empty($checkSource)) {
            return;
        }

        $this->source_id = Source::DEFAULT_SOURCE;
        if ($this->scenario == self::SCENARIO_BY_PARAMS) {
            $this->source_id = Source::SOURCE_OPERATOR;
        }
    }
}
