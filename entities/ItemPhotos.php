<?php

namespace afzalroq\cms\entities;

use afzalroq\cms\components\Image;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * This is the model class for table "cmc_item_photos".
 *
 * @property int $id
 * @property int $cms_item_id
 * @property string $file
 * @property int $sort
 * @property int $status
 * @property int $created_by
 * @property int $updated_by
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Items $item
 * @property Items[] $items
 */
class ItemPhotos extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'cms_item_photos';
    }

    public static function create(UploadedFile $file, int $id): self
    {
        $photo = new static();
        $photo->cms_item_id = $id;
        $photo->file = $file;
        return $photo;
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'cms_item_id' => Yii::t('app', 'Item ID'),
            'file' => Yii::t('app', 'File'),
            'sort' => Yii::t('app', 'Sort'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    public function setSort($sort): void
    {
        $this->sort = $sort;
    }

    public function isIdEqualTo($id): bool
    {
        return $this->id == $id;
    }

    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'file',
                'createThumbsOnRequest' => true,
                'filePath' => '@storageRoot/data/itemphotos/[[attribute_cms_item_id]]/[[filename]].[[extension]]',
                'fileUrl' => '@storageHostInfo/data/itemphotos/[[attribute_cms_item_id]]/[[filename]].[[extension]]',

                'thumbPath' => '@storageRoot/cache/itemphotos/[[attribute_cms_item_id]]/[[profile]]_[[filename]].[[extension]]',
                'thumbUrl' => '@storageHostInfo/cache/itemphotos/[[attribute_cms_item_id]]/[[profile]]_[[filename]].[[extension]]',

                'thumbs' => [
                    'admin' => ['width' => 100, 'height' => 70],
                    'thumb' => ['width' => 640, 'height' => 480],
                ],
            ],
        ];
    }

    public function getItem()
    {
        return $this->hasOne(Items::class, ['id' => 'cms_item_id']);
    }

    public function getPhoto($width, $height, $operation = null, $background = null, $xPos = null, $yPos = null)
    {
        return Image::get($this->item, 'file', $width, $height, $operation, $background, $xPos, $yPos, $this);
    }

}
