<?php

namespace afzalroq\cms\components;

use Gregwar\Image\Image as GregImage;
use Yii;
use yii\helpers\StringHelper;

class Image
{
    public static function get($obj, $attr, $width, $height, $operation)
    {
        $operation = $operation ?: 'cropResize';

        $module = Yii::$app->getModule('cms');
        $file = $module->path . '/data/' . mb_strtolower(StringHelper::basename($obj::className())) . '/' . $obj->id . '/' . $obj[$attr];

        $path = GregImage::open($file)
            ->setCacheDir($module->path . '/cache')
            ->{$operation}($width, $height)
            ->setFallback($module->fallback)
            ->guess();

        return $module->host . str_replace($module->path, '', $path);
    }
}
