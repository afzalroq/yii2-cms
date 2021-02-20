<?php

namespace afzalroq\cms\components;

use Gregwar\Image\Image as GregImage;
use Yii;
use yii\helpers\StringHelper;

class Image
{
    public static function get($obj, $attr, $width, $height, $operation, $background, $xPos, $yPos)
    {
        $module = Yii::$app->getModule('cms');
        $file = $module->path . '/data/' . mb_strtolower(StringHelper::basename($obj::className())) . '/' . $obj->id . '/' . $obj[$attr];

        $path = GregImage::open($file)
            ->setCacheDir($module->path . '/cache')
            ->setFallback($module->fallback);

        $operation = $operation ?: $module->imageOperation;
        $background = $background ?: $module->imageBackground;
        $xPos = $xPos ?: $module->imageXPos;
        $yPos = $yPos ?: $module->imageYPos;
        if ($operation === 'zoomCrop') {
            $path->{$operation}($width, $height, $background, $xPos, $yPos);
        } else {
            $path->{$operation}($width, $height, $background);
        }

        return $module->host . str_replace($module->path, '', $path->guess());
    }
}
