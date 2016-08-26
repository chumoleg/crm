<?php

namespace common\components\controllers;

use yii\web\Controller;
use yii\helpers\Html;

class BaseController extends Controller
{
    public $breadCrumbs = [];

    /**
     * @param string            $label
     * @param null|string|array $url
     */
    public function addBreadCrumb($label, $url = null)
    {
        $params = [
            'label' => $label
        ];

        if (!empty($url)) {
            $params['url'] = $url;
        }

        $this->breadCrumbs[] = $params;
    }

    /**
     * @param string $label
     * @param null   $url
     * @param bool   $showDivBlock
     *
     * @return string
     */
    public function getCreateButton($label, $url = null, $showDivBlock = true)
    {
        if (empty($url)) {
            $url = ['create'];
        }

        $html = Html::a($label, $url, ['class' => 'btn btn-success']) . '&nbsp;';
        if ($showDivBlock) {
            $html .= Html::tag('div', '&nbsp;');
        }

        return $html;
    }
}