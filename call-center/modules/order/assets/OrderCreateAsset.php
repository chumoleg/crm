<?php

namespace frontend\modules\order\assets;

class OrderCreateAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@app/modules/order/assets/source';
    public $js
        = [
            'js/common.js',
            'js/order-create.js',
        ];

    public $depends
        = [
            'frontend\assets\AppAsset',
        ];
}
