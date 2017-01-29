<?php

namespace common\models\stage;

use common\components\base\ActiveRecord;
use common\components\helpers\ArrayHelper;

/**
 * This is the model class for table "stage_method".
 *
 * @property integer $id
 * @property integer $stage_id
 * @property integer $method
 * @property string  $date_create
 *
 * @property Stage   $stage
 */
class StageMethod extends ActiveRecord
{
    const METHOD_CALL = 1;
    const METHOD_WRITE_PRODUCT_COMPONENTS = 2;
    const METHOD_RETURN_PRODUCT_COMPONENTS = 3;
    const METHOD_MANAGE_PRODUCTS = 4;
    const HIDE_ORDER_FROM_LIST = 5;

    public static $methodList
        = [
            self::METHOD_CALL                      => 'Возможность звонить',
            self::METHOD_WRITE_PRODUCT_COMPONENTS  => 'Проведение операции списания комплектующих',
            self::METHOD_RETURN_PRODUCT_COMPONENTS => 'Проведение операции возврата комплектующих',
            self::METHOD_MANAGE_PRODUCTS           => 'Возможность добавлять/удалять товары',
            self::HIDE_ORDER_FROM_LIST             => 'Скрывать заказ из списка',
        ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stage_method';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stage_id', 'method'], 'required'],
            [['stage_id', 'method'], 'integer'],
            [['date_create'], 'safe'],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStage()
    {
        return $this->hasOne(Stage::className(), ['id' => 'stage_id']);
    }

    public static function addNewRow(Stage $stage, $method)
    {
        $model = new self();
        $model->stage_id = $stage->id;
        $model->method = $method;
        $model->save();
    }

    /**
     * @param $method
     *
     * @return array
     */
    public static function getStagesList($method)
    {
        $data = self::find()->andWhere(['method' => $method])->all();

        return ArrayHelper::getColumn($data, 'stage_id');
    }
}
