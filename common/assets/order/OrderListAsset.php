<?php

namespace common\assets\order;

class OrderListAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@frontend/web/source';
    public $js
        = [
            'js/order/order-list.js',
        ];

    public $depends
        = [
            'common\assets\AppAsset',
        ];
}
