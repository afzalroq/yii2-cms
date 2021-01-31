<?php

namespace afzalroq\cms\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class MenuAsset extends AssetBundle
{
    public $sourcePath = '@vendor/afzalroq/yii2-cms/assets';

    public $js = [
        'js/menu.js',
    ];

    public $depends = [
        JqueryAsset::class
    ];
}