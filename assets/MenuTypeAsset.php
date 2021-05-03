<?php

namespace afzalroq\cms\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class MenuTypeAsset extends AssetBundle
{
    public $sourcePath = __DIR__;

    public $js = [
        'js/menuType.js',
    ];

    public $depends = [
        JqueryAsset::class
    ];

}