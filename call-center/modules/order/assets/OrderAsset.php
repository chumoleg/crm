<?php

namespace frontend\modules\order\assets;

class OrderAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@app/modules/order/assets/source';
    public $js
        = [
            'js/common.js',
            'js/order.js',
            'js/order-status.js',
        ];
    public $css
        = [
            'css/order.css',
        ];

    public $depends
        = [
            'frontend\assets\AppAsset',
        ];
}
