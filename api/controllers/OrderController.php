<?php

namespace api\controllers;

use common\forms\CreateOrderForm;
use yii\rest\ActiveController;

class OrderController extends ActiveController
{
    public $modelClass = CreateOrderForm::class;
    public $createScenario = CreateOrderForm::SCENARIO_BY_API;
}
