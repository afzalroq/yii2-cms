<?php

namespace afzalroq\cms\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class GalleryAsset extends AssetBundle
{

    public $sourcePath = __DIR__;

    public $css = [
        'css/image-preview.css'
    ];

    public $depends = [
        JqueryAsset::class
    ];
}