<?php

namespace common\forms;

use Yii;
use common\models\company\Company;
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

    public $product_data_checker;
    public $product_data = [];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(
            [
                [['company_customer'], 'required'],
                [['company_customer'], 'validateCompanyCustomer', 'on' => self::SCENARIO_BY_PARAMS],
                [['product_data'], 'required', 'on' => self::SCENARIO_BY_API],
                [['product_data_checker', 'company_executor'], 'required', 'on' => self::SCENARIO_BY_PARAMS],
                ['product_data', 'validateProductData', 'on' => self::SCENARIO_BY_API],
                ['product_data_checker', 'validateProductData', 'on' => self::SCENARIO_BY_PARAMS],
                [['product_data'], 'safe'],
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

    public function validateCompanyCustomer($attribute)
    {
        $companyList = Company::getListCustomers();
        if (!isset($companyList[$this->company_customer])) {
            $this->addError($attribute, 'Невозможно выбрать данную организацию');
        }
    }

    public function beforeSave($insert)
    {
        $this->_setSourceId();
        $this->_setCompanyExecutor();
        $this->_setProcessId();

        $price = 0;
        foreach ($this->product_data as $productItem) {
            $quantity = ArrayHelper::getValue($productItem, 'quantity', 1);
            $price += $productItem['price'] * $quantity;
        }

        $this->price = $price;
        $this->currency = Currency::RUR;
        $this->created_user_id = ($this->scenario == self::SCENARIO_BY_PARAMS)
            ? Yii::$app->user->id : null;

        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        $this->_saveProducts();
        $this->saveFirstOrderStage();

        parent::afterSave($insert, $changedAttributes);
    }

    public function fields()
    {
//        $post = [
//            'source_id'        => 'Источник',
//            'name'             => 'Название',
//            'company_customer' => 'Организация (клиент)',
//            'product_data'     => [
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

    private function _setCompanyExecutor()
    {
        if (!empty($this->company_executor)) {
            return;
        }

        $executorList = Company::getListExecutors();

        $this->company_executor = key($executorList);
    }

    private function _setSourceId()
    {
        $checkSource = Source::findById($this->source_id);
        if (!empty($checkSource)) {
            return;
        }

        $this->source_id = Source::DEFAULT_SOURCE;
        if ($this->scenario == self::SCENARIO_BY_PARAMS) {
            $this->source_id = Source::SOURCE_OPERATOR;
        }
    }
}
