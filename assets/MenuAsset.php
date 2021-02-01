<?php

namespace afzalroq\cms\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class MenuAsset extends AssetBundle
{
    public $sourcePath = __DIR__;

    public $js = [
        'js/menu.js',
    ];

    public $depends = [
        JqueryAsset::class
    ];
}