<?php

namespace common\assets\order;

class OrderCreateAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@frontend/web/source';
    public $js
        = [
            'js/order/common.js',
            'js/order/order-create.js',
        ];

    public $depends
        = [
            'common\assets\AppAsset',
        ];
}
