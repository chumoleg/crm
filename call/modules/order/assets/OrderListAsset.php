<?php

namespace call\modules\order\assets;

class OrderListAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@app/modules/order/assets/source';
    public $js
        = [
            'js/order-list.js',
        ];

    public $depends
        = [
            'call\assets\AppAsset',
        ];
}
