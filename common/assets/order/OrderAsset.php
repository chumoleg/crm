<?php

namespace common\assets\order;

class OrderAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@frontend/web/source';
    public $js
        = [
            'js/order/common.js',
            'js/order/order.js',
            'js/order/order-status.js',
        ];
    public $css
        = [
            'css/order/order.css',
        ];

    public $depends
        = [
            'common\assets\AppAsset',
        ];
}
