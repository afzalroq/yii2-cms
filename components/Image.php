<?php

namespace afzalroq\cms\components;

use Gregwar\Image\Image as GregImage;
use Yii;
use yii\helpers\StringHelper;

class Image
{
    public static function get($obj, $attr, $width, $height, $operation, $background, $xPos, $yPos, $itemPhotos = null)
    {

        $file = $itemPhotos ? $itemPhotos[$attr] : $obj[$attr];
        $module = Yii::$app->getModule('cms');
        $file = $module->path . '/data/' . mb_strtolower(StringHelper::basename($itemPhotos ? $itemPhotos::className() : $obj::className())) . '/' . $obj->id . '/' . $file;

        $path = GregImage::open($file)
            ->setCacheDir($module->path . '/cache')
            ->setFallback($module->fallback);
        if (!file_exists($file)) {
            $path = GregImage::open($module->path . '/fallback.png')
                ->setCacheDir($module->path . '/cache');
        }
        $operation = $operation ?: $module->imageOperation;
        $background = $background ?: $module->imageBackground;
        $xPos = $xPos ?: $module->imageXPos;
        $yPos = $yPos ?: $module->imageYPos;
        if ($operation === 'zoomCrop') {
            $path->{$operation}($width, $height, $background, $xPos, $yPos);
        } else {
            $path->{$operation}($width, $height, $background);
        }
        if (isset($obj->entity) && $obj->entity->use_watermark && is_file($module->watermark)) {
            $watermark = GregImage::open($module->watermark)->scaleResize(intval($width * 15 / 100), intval($height * 15 / 100));
            $path->merge($watermark, $width - intval($width * 17 / 100), $height - intval($width * 17 / 100));
        }
//        if (isset(Yii::$app->params['sss']) && Yii::$app->params['sss']){
//            dd($path->guess());
//        }

        return $module->host . str_replace($module->path, '', $path->guess());
    }

}
