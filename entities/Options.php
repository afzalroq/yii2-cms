<?php

namespace afzalroq\cms\entities;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yiidreamteam\upload\FileUploadBehavior;
use afzalroq\cms\components\FileType;
use afzalroq\cms\components\Image;

/**
 * This is the model class for table "cms_options".
 *
 * @property int $id
 * @property int $collection_id
 * @property int|null $parent_id
 * @property string $slug
 * @property string|null $name_0
 * @property string|null $name_1
 * @property string|null $name_2
 * @property string|null $name_3
 * @property string|null $name_4
 * @property string|null $content_0
 * @property string|null $content_1
 * @property string|null $content_2
 * @property string|null $content_3
 * @property string|null $content_4
 * @property string|null $file_1_0
 * @property string|null $file_1_1
 * @property string|null $file_1_2
 * @property string|null $file_1_3
 * @property string|null $file_1_4
 * @property string|null $file_2_0
 * @property string|null $file_2_1
 * @property string|null $file_2_2
 * @property string|null $file_2_3
 * @property string|null $file_2_4
 * @property int $seo_values
 * @property int $sort
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Collections $collection
 * @property Collections $parentCollection
 */
class Options extends ActiveRecord
{
    #region Extra Attributes

    public $parentCollection;

    public $meta_title_0;
    public $meta_title_1;
    public $meta_title_2;
    public $meta_title_3;
    public $meta_title_4;
    public $meta_des_0;
    public $meta_des_1;
    public $meta_des_2;
    public $meta_des_3;
    public $meta_des_4;
    public $meta_keyword_0;
    public $meta_keyword_1;
    public $meta_keyword_2;
    public $meta_keyword_3;
    public $meta_keyword_4;

    #endregion

    #region Overwrite Methods
    public static function tableName()
    {
        return 'cms_options';
    }

    public function rules()
    {
        return [
            [['file_1_0', 'file_1_1', 'file_1_2', 'file_1_3', 'file_1_4'],
                'file',
                'extensions' => FileType::fileExtensions($this->parentCollection->file_1_mimeType),
                'maxSize' => $this->parentCollection->file_1_maxSize * 1024 * 1024
            ],

            [['file_2_0', 'file_2_1', 'file_2_2', 'file_2_3', 'file_2_4'],
                'file',
                'extensions' => FileType::fileExtensions($this->parentCollection->file_2_mimeType),
                'maxSize' => $this->parentCollection->file_2_maxSize * 1024 * 1024
            ],

            [['collection_id', 'slug'], 'required'],
            [['collection_id', 'parent_id', 'sort', 'created_at', 'updated_at'], 'integer'],
            [['content_0', 'content_1', 'content_2', 'content_3', 'content_4'], 'string'],
            [['slug', 'name_0', 'name_1', 'name_2', 'name_3', 'name_4', 'meta_title_0', 'meta_des_0', 'meta_keyword_0', 'meta_title_1', 'meta_keyword_1', 'meta_des_1', 'meta_title_2', 'meta_des_2', 'meta_keyword_2', 'meta_title_3', 'meta_des_3', 'meta_keyword_3', 'meta_title_4', 'meta_des_4', 'meta_keyword_4'], 'string', 'max' => 255],
            [['slug'], 'unique'],
            [['collection_id'], 'exist', 'skipOnError' => true, 'targetClass' => Collections::class, 'targetAttribute' => ['collection_id' => 'id']],
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            $this->getFileUploadBehaviorConfig('file_1_0'),
            $this->getFileUploadBehaviorConfig('file_1_1'),
            $this->getFileUploadBehaviorConfig('file_1_2'),
            $this->getFileUploadBehaviorConfig('file_1_3'),
            $this->getFileUploadBehaviorConfig('file_1_4'),
            $this->getFileUploadBehaviorConfig('file_2_0'),
            $this->getFileUploadBehaviorConfig('file_2_1'),
            $this->getFileUploadBehaviorConfig('file_2_2'),
            $this->getFileUploadBehaviorConfig('file_2_3'),
            $this->getFileUploadBehaviorConfig('file_2_4')
        ];
    }

    public function beforeSave($insert)
    {
        if ($this->collection->use_seo)
            $this->seo_values = [
                'meta_title_0' => $this->meta_title_0 ?? null,
                'meta_title_1' => $this->meta_title_1 ?? null,
                'meta_title_2' => $this->meta_title_2 ?? null,
                'meta_title_3' => $this->meta_title_3 ?? null,
                'meta_title_4' => $this->meta_title_4 ?? null,

                'meta_des_0' => $this->meta_des_0 ?? null,
                'meta_des_1' => $this->meta_des_1 ?? null,
                'meta_des_2' => $this->meta_des_2 ?? null,
                'meta_des_3' => $this->meta_des_3 ?? null,
                'meta_des_4' => $this->meta_des_4 ?? null,

                'meta_keyword_0' => $this->meta_keyword_0 ?? null,
                'meta_keyword_1' => $this->meta_keyword_1 ?? null,
                'meta_keyword_2' => $this->meta_keyword_2 ?? null,
                'meta_keyword_3' => $this->meta_keyword_3 ?? null,
                'meta_keyword_4' => $this->meta_keyword_4 ?? null
            ];

        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    public function attributeLabels()
    {
        $language0 = isset(Yii::$app->params['cms']['languages2'][0]) ? Yii::$app->params['cms']['languages2'][0] : '';
        $language1 = isset(Yii::$app->params['cms']['languages2'][1]) ? Yii::$app->params['cms']['languages2'][1] : '';
        $language2 = isset(Yii::$app->params['cms']['languages2'][2]) ? Yii::$app->params['cms']['languages2'][2] : '';
        $language3 = isset(Yii::$app->params['cms']['languages2'][3]) ? Yii::$app->params['cms']['languages2'][3] : '';
        $language4 = isset(Yii::$app->params['cms']['languages2'][4]) ? Yii::$app->params['cms']['languages2'][4] : '';

        return [
            'id' => Yii::t('cms', 'ID'),
            'slug' => Yii::t('cms', 'Slug'),
            'name_0' => Yii::t('cms', 'Name') . '(' . $language0 . ')',
            'name_1' => Yii::t('cms', 'Name') . '(' . $language1 . ')',
            'name_2' => Yii::t('cms', 'Name') . '(' . $language2 . ')',
            'name_3' => Yii::t('cms', 'Name') . '(' . $language3 . ')',
            'name_4' => Yii::t('cms', 'Name') . '(' . $language4 . ')',
            'content_0' => Yii::t('cms', 'Content') . '(' . $language0 . ')',
            'content_1' => Yii::t('cms', 'Content') . '(' . $language1 . ')',
            'content_2' => Yii::t('cms', 'Content') . '(' . $language2 . ')',
            'content_3' => Yii::t('cms', 'Content') . '(' . $language3 . ')',
            'content_4' => Yii::t('cms', 'Content') . '(' . $language4 . ')',
            'file_1_0' => Yii::t('cms', 'File') . '1(' . $language0 . ')',
            'file_1_1' => Yii::t('cms', 'File') . '1(' . $language1 . ')',
            'file_1_2' => Yii::t('cms', 'File') . '1(' . $language2 . ')',
            'file_1_3' => Yii::t('cms', 'File') . '1(' . $language3 . ')',
            'file_1_4' => Yii::t('cms', 'File') . '1(' . $language3 . ')',
            'file_2_0' => Yii::t('cms', 'File') . '2(' . $language0 . ')',
            'file_2_1' => Yii::t('cms', 'File') . '2(' . $language1 . ')',
            'file_2_2' => Yii::t('cms', 'File') . '2(' . $language2 . ')',
            'file_2_3' => Yii::t('cms', 'File') . '2(' . $language3 . ')',
            'file_2_4' => Yii::t('cms', 'File') . '2(' . $language4 . ')',
            'meta_title_0' => Yii::t('cms', 'Seo Title') . '(' . $language0 . ')',
            'meta_des_0' => Yii::t('cms', 'Seo Description') . '(' . $language0 . ')',
            'meta_keyword_0' => Yii::t('cms', 'Seo Keywords') . '(' . $language0 . ')',
            'meta_title_1' => Yii::t('cms', 'Seo Title') . '(' . $language1 . ')',
            'meta_des_1' => Yii::t('cms', 'Seo Description') . '(' . $language1 . ')',
            'meta_keyword_1' => Yii::t('cms', 'Seo Keywords') . '(' . $language1 . ')',
            'meta_title_2' => Yii::t('cms', 'Seo Title') . '(' . $language2 . ')',
            'meta_des_2' => Yii::t('cms', 'Seo Description') . '(' . $language2 . ')',
            'meta_keyword_2' => Yii::t('cms', 'Seo Keywords') . '(' . $language2 . ')',
            'meta_title_3' => Yii::t('cms', 'Seo Title') . '(' . $language3 . ')',
            'meta_des_3' => Yii::t('cms', 'Seo Description') . '(' . $language3 . ')',
            'meta_keyword_3' => Yii::t('cms', 'Seo Keywords') . '(' . $language3 . ')',
            'meta_title_4' => Yii::t('cms', 'Seo Title') . '(' . $language4 . ')',
            'meta_des_4' => Yii::t('cms', 'Seo Description') . '(' . $language4 . ')',
            'meta_keyword_4' => Yii::t('cms', 'Seo Keywords') . '(' . $language4 . ')',
            'sort' => Yii::t('cms', 'Sort'),
            'created_at' => Yii::t('cms', 'Created At'),
            'updated_at' => Yii::t('cms', 'Updated At'),
        ];
    }
    #endregion

    #region Extra Methods

    public function getParentValue()
    {
        return ($this->parent_id)
            ? Html::a(
                $this->parent->slug,
                \yii\helpers\Url::to(['/cms/options/view', 'id' => $this->parent_id, 'slug' => $this->collection->slug])
            )
            : null;
    }

    public function getFileAttrValue($attr)
    {
        $entityAttr = substr($attr, 0, -2);
        switch (FileType::fileMimeType($this->collection[$entityAttr . '_mimeType'])) {
            case FileType::TYPE_FILE:
                return $this->{$attr};
            case FileType::TYPE_IMAGE:
                return Html::img($this->getImageUrl(
                    $attr,
                    $this->collection[$entityAttr . '_dimensionW'],
                    $this->collection[$entityAttr . '_dimensionH']
                ));
            default:
                return null;
        }
    }

    public function getCorT($justAttr)
    {
        if (!$this->collection)
            return null;

        $attrValue = $this->collection['option_' . $justAttr];
        switch ($justAttr) {
            case 'name':
                if ($attrValue === Collections::OPTION_NAME_COMMON)
                    return false;
                elseif ($attrValue === Collections::OPTION_NAME_TRANSLATABLE)
                    return true;
                break;
            case 'content':
                if ($attrValue === Collections::OPTION_CONTENT_COMMON_TEXTAREA
                    || $attrValue === Collections::OPTION_CONTENT_COMMON_CKEDITOR)
                    return false;
                elseif ($attrValue !== Collections::OPTION_CONTENT_DISABLED)
                    return true;
                break;
            case 'file_1':
            case 'file_2':
                if ($attrValue === Collections::OPTION_FILE_COMMON)
                    return false;
                elseif ($attrValue === Collections::OPTION_FILE_TRANSLATABLE)
                    return true;
                break;
            default:
                return null;
        }

        return null;
    }

    private function getFileUploadBehaviorConfig($attribute)
    {
        $module = Yii::$app->getModule('cms');

        return [
            'class' => FileUploadBehavior::class,
            'attribute' => $attribute,
            'filePath' => $module->storageRoot . '/data/options/[[attribute_id]]/[[filename]].[[extension]]',
            'fileUrl' => $module->storageHost . '/data/options/[[attribute_id]]/[[filename]].[[extension]]',
        ];
    }

    public function getImageUrl($attr, $width = null, $height = null, $resizeType = 'resize')
    {
        return Image::get($this, $attr, $width, $height, $resizeType);
    }

    public function getCollection()
    {
        return $this->hasOne(Collections::class, ['id' => 'collection_id']);
    }
    #endregion
}
