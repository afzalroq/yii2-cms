<?php

namespace abdualiym\cms\entities;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use yiidreamteam\upload\ImageUploadBehavior;
use Gregwar\Image\Image as GregImage;

/**
 * This is the model class for table "abdualiym_cms_articles".
 *
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
    	if($obj->{$attr} === null)
    		return null;
        if(!$operation)
            $operation = 'cropResize';

        $file = Yii::getAlias('@storage/data/' . mb_strtolower(StringHelper::basename($obj::className())) . '/') . $obj->id . '/' . $obj[$attr];
        return '/' . GregImage::open($file)
                ->{$operation}($width,$height)
//                ->setFallback('asd')
                ->guess();
    }

}
