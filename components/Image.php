<?php

namespace afzalroq\cms\components;

use Gregwar\Image\Image as GregImage;
use Yii;
use yii\helpers\StringHelper;

/**
 * @property int $id
 * @property int $category_id
 * @property string $title_0
 * @property string $title_1
 * @property string $title_2
 * @property string $title_3
 * @property string $slug
 * @property string $content_0
 * @property string $content_1
 * @property string $content_2
 * @property string $content_3
 * @property string $photo
 * @property int $date
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class Image
{
    public static function get($obj, $attr, $width, $height, $operation)
    {
        if ($obj->{$attr} === null)
            return null;

        if (!$operation)
            $operation = 'cropResize';

        $module = Yii::$app->getModule('cms');
        $file = $module->path . '/data/' . mb_strtolower(StringHelper::basename($obj::className())) . '/' . $obj->id . '/' . $obj[$attr];
        $path = GregImage::open($file)->setCacheDir($module->path . '/cache')
            ->{$operation}($width, $height)
            ->setFallback($module->fallback)
            ->guess();

        return $module->host . str_replace($module->fullPath, '', $path);
    }
}
