<?php

namespace common\forms;

use Yii;
use common\components\nomenclature\TypeDelivery;
use common\components\nomenclature\TypePayment;
use common\models\order\OrderProduct;
use common\models\process\Process;
use common\models\order\Order;
use common\models\client\Client;
use common\components\helpers\ArrayHelper;
use common\components\nomenclature\Currency;
use common\models\product\Product;
use common\models\source\Source;
use common\components\Role;
use common\models\geo\GeoAddress;
use common\models\geo\GeoArea;

class CreateOrderForm extends Order
{
    const SCENARIO_BY_PARAMS = 'createByParams';
    const SCENARIO_BY_CLIENT = 'createByClient';
    const SCENARIO_BY_API = 'createByApi';

    public $clientId;

    public $source;
    public $fio;
    public $phone;

    public $typePayment;
    public $typeDelivery;
    public $deliveryPrice = 0;

    public $addressAreaId;
    public $addressPostIndex;

    public $product_data_checker;
    public $product_data = [];

    /**
     * @var Client
     */
    private $_clientModel;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge([
            [['addressPostIndex', 'fio', 'phone'], 'filter', 'filter' => 'trim'],
            [['product_data'], 'required', 'on' => self::SCENARIO_BY_API],
            [['product_data_checker'], 'required', 'on' => [self::SCENARIO_BY_PARAMS, self::SCENARIO_BY_CLIENT]],
            [['fio', 'phone'], 'required', 'on' => [self::SCENARIO_BY_PARAMS, self::SCENARIO_BY_API]],
            [['clientId'], 'required', 'on' => self::SCENARIO_BY_CLIENT],
            [['deliveryPrice', 'addressPostIndex'], 'number'],
            [['addressAreaId', 'source'], 'integer'],
            [['product_data', 'typePayment', 'typeDelivery'], 'safe'],
            ['product_data', 'validateProductData', 'on' => self::SCENARIO_BY_API],
            [
                'product_data_checker',
                'validateProductData',
                'on' => [self::SCENARIO_BY_CLIENT, self::SCENARIO_BY_PARAMS]
            ],
        ], parent::rules());
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge([
            'source'               => 'Источник',
            'addressAreaId'        => 'Область',
            'addressPostIndex'     => 'Почтовый индекс',
            'fio'                  => 'ФИО клиента',
            'phone'                => 'Телефон клиента',
            'typePayment'          => 'Тип оплаты',
            'typeDelivery'         => 'Тип доставки',
            'deliveryPrice'        => 'Стоимость доставки',
            'product_data'         => 'Товары',
            'product_data_checker' => 'Товары',
        ], parent::attributeLabels());
    }

    public function beforeValidate()
    {
        $this->_formatPhone();
        if (!empty($this->product_data)) {
            $this->product_data_checker = true;
        }

        if (empty($this->addressAreaId)) {
            $this->addressAreaId = GeoArea::DEFAULT_AREA;
        }

        if (empty($this->addressPostIndex)) {
            $this->addressPostIndex = GeoAddress::DEFAULT_POST_INDEX;
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

    public function afterValidate()
    {
        if (empty($this->clientId)) {
            $this->_clientModel = Client::getModel($this->phone, $this->fio, $this->_getAddressData());

        } else {
            $this->_clientModel = Client::findById($this->clientId);
        }

        if (empty($this->_clientModel)) {
            $this->addError('fio', 'Ошибка при сохранении данных клиента!');
            return;
        }

        parent::afterValidate();
    }

    public function beforeSave($insert)
    {
        $this->_setSourceId();
        $this->_setProcessId();
        $this->_setAddressId();
        $this->_setTypePayment();
        $this->_setTypeDelivery();

        $this->client_id = $this->_clientModel->id;
        $this->client_phone_id = ArrayHelper::getValue($this->_clientModel, 'mainPhone.id');
        $this->client_personal_data_id = ArrayHelper::getValue($this->_clientModel, 'mainPersonalData.id');

        $this->price = array_sum(array_column($this->product_data, 'price')) + $this->deliveryPrice;
        $this->delivery_price = $this->deliveryPrice;
        $this->currency = Currency::RUR;
        $this->create_user_id = !empty($this->clientId) ? Yii::$app->user->id : null;

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
//            'fio'          => 'ФИО клиента',
//            'phone'        => 'Телефон клиента',
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

    private function _formatPhone()
    {
        $phoneNumber = preg_replace('/[^0-9]/u', '', $this->phone);
        $firstSymbol = substr($phoneNumber, 0, 1);

        if (strlen($phoneNumber) == 11 && $firstSymbol == 7) {
            $phoneNumber = '8' . substr($phoneNumber, 1, strlen($phoneNumber) - 1);
        }

        if (strlen($phoneNumber) == 10 && $firstSymbol != 8) {
            $phoneNumber = '8' . $phoneNumber;
        }

        $this->phone = $phoneNumber;
    }

    /**
     * @return array
     */
    private function _getAddressData()
    {
        $addressData = [
            'area_id'    => $this->addressAreaId,
            'post_index' => $this->addressPostIndex
        ];
        return $addressData;
    }

    private function _saveProducts()
    {
        foreach ($this->product_data as $item) {
            OrderProduct::addByParams($this, $item['product_id'], $item['price'],
                ArrayHelper::getValue($item, 'quantity', 1), $this->currency);
        }
    }

    private function _setAddressId()
    {
        $addressId = ArrayHelper::getValue($this->_clientModel, 'mainAddress.address_id');
        if (empty($addressId)) {
            $addressId = Client::createNewAddress($this->_clientModel->id, $this->_getAddressData());
        }

        $this->address_id = $addressId;
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

        if (!empty($this->clientId)) {
            $this->source_id = Source::SOURCE_OPERATOR;
        } else {
            $this->source_id = Source::DEFAULT_SOURCE;
        }
    }

    private function _setTypeDelivery()
    {
        $this->type_delivery = $this->typeDelivery;
        if (empty($this->type_delivery)) {
            $this->type_delivery = TypeDelivery::POST;
        }
    }

    private function _setTypePayment()
    {
        $this->type_payment = $this->typePayment;
        if (empty($this->type_payment)) {
            $this->type_payment = TypePayment::POST_PAYMENT;
        }
    }
}
