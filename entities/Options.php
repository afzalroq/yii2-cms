<?php

namespace afzalroq\cms\entities;

use afzalroq\cms\components\FileType;
use afzalroq\cms\components\Image;
use afzalroq\cms\entities\query\OptionsQuery;
use afzalroq\cms\Module;
use creocoder\nestedsets\NestedSetsBehavior;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\caching\TagDependency;
use yii\db\ActiveRecord;
use yii\db\Exception;
use yii\helpers\Html;
use yiidreamteam\upload\FileUploadBehavior;

/**
 * This is the model class for table "cms_options".
 *
 * @property int $id
 * @property int $collection_id
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
 * @property string|null $text_1_0
 * @property string|null $text_1_1
 * @property string|null $text_1_2
 * @property string|null $text_1_3
 * @property string|null $text_1_4
 * @property string|null $text_2_0
 * @property string|null $text_2_1
 * @property string|null $text_2_2
 * @property string|null $text_2_3
 * @property string|null $text_2_4
 * @property string|null $text_3_0
 * @property string|null $text_3_1
 * @property string|null $text_3_2
 * @property string|null $text_3_3
 * @property string|null $text_3_4
 * @property string|null $text_4_0
 * @property string|null $text_4_1
 * @property string|null $text_4_2
 * @property string|null $text_4_3
 * @property string|null $text_4_4
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
    public $languageId;
    public $treeAttribute = 'tree';
    public $dependCollection;
    private $cpId;

    #endregion

    #region Overwrite Methods

    public function __construct($slug = null, $config = [])
    {
        if ($slug) {
            $this->dependCollection = Collections::findOne(['slug' => $slug]);
            if ($this->dependCollection->manual_slug) $this->detachBehavior('slug');
        } else {

            $this->dependCollection = $this->collection;
        }
        $this->setCurrentLanguage();
        parent::__construct($config);
    }

    private function setCurrentLanguage()
    {
        $this->languageId = \Yii::$app->params['l'][\Yii::$app->language];
        if (!$this->languageId)
            $this->languageId = 0;
    }

    public static function tableName()
    {
        return 'cms_options';
    }

    public static function find()
    {
        return new OptionsQuery(get_called_class());
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class,
            $this->getFileUploadBehaviorConfig('file_1_0'),
            $this->getFileUploadBehaviorConfig('file_1_1'),
            $this->getFileUploadBehaviorConfig('file_1_2'),
            $this->getFileUploadBehaviorConfig('file_1_3'),
            $this->getFileUploadBehaviorConfig('file_1_4'),
            $this->getFileUploadBehaviorConfig('file_2_0'),
            $this->getFileUploadBehaviorConfig('file_2_1'),
            $this->getFileUploadBehaviorConfig('file_2_2'),
            $this->getFileUploadBehaviorConfig('file_2_3'),
            $this->getFileUploadBehaviorConfig('file_2_4'),
            'tree' => [
                'class' => NestedSetsBehavior::class,
                'treeAttribute' => $this->treeAttribute,
                // 'leftAttribute' => 'lft',
                // 'rightAttribute' => 'rgt',
                // 'depthAttribute' => 'depth',
            ],
            'slug' => [
                'class' => 'Zelenin\yii\behaviors\Slug',
                'slugAttribute' => 'slug',
                'attribute' => 'name_0',
                // o3ptional params
                'ensureUnique' => true,
                'replacement' => '-',
                'lowercase' => true,
                // false = changes after every change for $attribute
                'immutable' => false,
                // If intl extension is enabled, see http://userguide.icu-project.org/transforms/general.
                'transliterateOptions' => 'Russian-Latin/BGN; Any-Latin; Latin-ASCII; NFD; [:Nonspacing Mark:] Remove; NFC;'
            ]
        ];
    }

    private function getFileUploadBehaviorConfig($attribute)
    {
        $module = Yii::$app->getModule('cms');

        return [
            'class' => FileUploadBehavior::class,
            'attribute' => $attribute,
            'filePath' => $module->path . '/data/options/[[attribute_id]]/[[filename]].[[extension]]',
            'fileUrl' => $module->host . '/data/options/[[attribute_id]]/[[filename]].[[extension]]',
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        TagDependency::invalidate(Yii::$app->{Yii::$app->getModule('cms')->cache}, 'options_' . $this->parentCollection->slug);
        return true;
    }

    public function afterFind()
    {
        parent::afterFind();

        if ($this->collection->manual_slug) {
            $this->detachBehavior('slug');
        }
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

    public function beforeDelete()
    {
        $this->cpId = $this->id;
        return parent::beforeDelete(); // TODO: Change the autogenerated stub
    }

    public function afterDelete()
    {
        parent::afterDelete();

        TagDependency::invalidate(Yii::$app->{Yii::$app->getModule('cms')->cache}, 'options_' . (Collections::findOne($this->collection_id))->slug);

        foreach (Menu::find()->all() as $menu) {
            if ($menu->type !== Menu::TYPE_OPTION)
                continue;
            if ($menu->type_helper != $this->cpId)
                continue;

            if (!$menu->delete())
                throw new Exception("Cannot delete id: {$menu->id} of menu");
        }
    }

    #endregion

    #region Extra Methods

    public function rules()
    {
        return [
            [['file_1_0', 'file_1_1', 'file_1_2', 'file_1_3', 'file_1_4'],
                'file',
                'extensions' => FileType::fileExtensions($this->parentCollection->file_1_mimeType),
                'maxSize' => ($this->parentCollection->file_1_maxSize ?: 0) * 1024 * 1024
            ],

            [['file_2_0', 'file_2_1', 'file_2_2', 'file_2_3', 'file_2_4'],
                'file',
                'extensions' => FileType::fileExtensions($this->parentCollection->file_2_mimeType),
                'maxSize' => ($this->parentCollection->file_2_maxSize ?: 0) * 1024 * 1024
            ],

            [['collection_id'], 'required'],
            [['collection_id', 'sort', 'created_at', 'updated_at'], 'integer'],
            [['content_0', 'content_1', 'content_2', 'content_3', 'content_4'], 'string'],
            [['slug', 'name_0', 'name_1', 'name_2', 'name_3', 'name_4', 'meta_title_0', 'meta_des_0', 'meta_keyword_0', 'meta_title_1', 'meta_keyword_1', 'meta_des_1', 'meta_title_2', 'meta_des_2', 'meta_keyword_2', 'meta_title_3', 'meta_des_3', 'meta_keyword_3', 'meta_title_4', 'meta_des_4', 'meta_keyword_4'], 'string', 'max' => 255],

            [['slug'], 'unique'],
            [['slug'], 'afzalroq\cms\validators\SlugValidator'],

            [['collection_id'], 'exist', 'skipOnError' => true, 'targetClass' => Collections::class, 'targetAttribute' => ['collection_id' => 'id']],
            [['text_1_0', 'text_1_1', 'text_1_2', 'text_1_3', 'text_1_4',
                'text_2_0', 'text_2_1', 'text_2_2', 'text_2_3', 'text_2_4',
                'text_3_0', 'text_3_1', 'text_3_2', 'text_3_3', 'text_3_4',
                'text_4_0', 'text_4_1', 'text_4_2', 'text_4_3', 'text_4_4'
            ], 'string'],
        ];
    }

    public function attributeLabels()
    {
        $language0 = isset(Yii::$app->params['cms']['languages'][0]) ? Yii::$app->params['cms']['languages'][0] : '';
        $language1 = isset(Yii::$app->params['cms']['languages'][1]) ? Yii::$app->params['cms']['languages'][1] : '';
        $language2 = isset(Yii::$app->params['cms']['languages'][2]) ? Yii::$app->params['cms']['languages'][2] : '';
        $language3 = isset(Yii::$app->params['cms']['languages'][3]) ? Yii::$app->params['cms']['languages'][3] : '';
        $language4 = isset(Yii::$app->params['cms']['languages'][4]) ? Yii::$app->params['cms']['languages'][4] : '';

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
            'text_1_0' => Yii::t('cms', 'Text 1') . '(' . $language0 . ')',
            'text_1_1' => Yii::t('cms', 'Text 1') . '(' . $language1 . ')',
            'text_1_2' => Yii::t('cms', 'Text 1') . '(' . $language2 . ')',
            'text_1_3' => Yii::t('cms', 'Text 1') . '(' . $language3 . ')',
            'text_1_4' => Yii::t('cms', 'Text 1') . '(' . $language4 . ')',
            'text_2_0' => Yii::t('cms', 'Text 2') . '(' . $language0 . ')',
            'text_2_1' => Yii::t('cms', 'Text 2') . '(' . $language1 . ')',
            'text_2_2' => Yii::t('cms', 'Text 2') . '(' . $language2 . ')',
            'text_2_3' => Yii::t('cms', 'Text 2') . '(' . $language3 . ')',
            'text_2_4' => Yii::t('cms', 'Text 2') . '(' . $language4 . ')',
            'text_3_0' => Yii::t('cms', 'Text 3') . '(' . $language0 . ')',
            'text_3_1' => Yii::t('cms', 'Text 3') . '(' . $language1 . ')',
            'text_3_2' => Yii::t('cms', 'Text 3') . '(' . $language2 . ')',
            'text_3_3' => Yii::t('cms', 'Text 3') . '(' . $language3 . ')',
            'text_3_4' => Yii::t('cms', 'Text 3') . '(' . $language4 . ')',
            'text_4_0' => Yii::t('cms', 'Text 4') . '(' . $language0 . ')',
            'text_4_1' => Yii::t('cms', 'Text 4') . '(' . $language1 . ')',
            'text_4_2' => Yii::t('cms', 'Text 4') . '(' . $language2 . ')',
            'text_4_3' => Yii::t('cms', 'Text 4') . '(' . $language3 . ')',
            'text_4_4' => Yii::t('cms', 'Text 4') . '(' . $language4 . ')',
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
            'created_by' => Yii::t('cms', 'Created By'),
            'updated_by' => Yii::t('cms', 'Updated By'),
            'created_at' => Yii::t('cms', 'Created At'),
            'updated_at' => Yii::t('cms', 'Updated At'),
        ];
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

    public function getImageUrl($attr, $width, $height, $operation = null, $background = null, $xPos = null, $yPos = null)
    {
        return Image::get($this, $attr, $width, $height, $operation, $background, $xPos, $yPos);
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

    public function isAttrDisabled($collectionAttr)
    {
        return !($this->isAttrCommon($collectionAttr) || $this->isAttrTranslatable($collectionAttr));
    }

    public function isAttrCommon($collectionAttr)
    {
        if (!$this->parentCollection)
            $this->parentCollection = $this->collection;

        switch ($this->parentCollection['option_' . $collectionAttr]) {
            case Collections::SEO_COMMON:
            case Collections::OPTION_FILE_COMMON:
            case Collections::OPTION_NAME_COMMON:
            case Collections::OPTION_CONTENT_COMMON_TEXTAREA:
            case Collections::OPTION_CONTENT_COMMON_CKEDITOR:
                return true;
            case Collections::SEO_DISABLED:
            case Collections::OPTION_FILE_DISABLED:
            case Collections::OPTION_NAME_DISABLED:
            case Collections::OPTION_CONTENT_DISABLED:
                return Collections::DISABLED;
        }
        return false;
    }

    public function isAttrCommonOptions($collectionAttr)
    {
        if (!$this->dependCollection)
            $this->dependCollection = $this->collection;

        switch ($this->dependCollection->{$collectionAttr}) {
            case Entities::TEXT_COMMON_INPUT_STRING:
            case Entities::TEXT_COMMON_INPUT_STRING_REQUIRED:
            case Entities::TEXT_COMMON_INPUT_INT:
            case Entities::TEXT_COMMON_INPUT_INT_REQUIRED:
            case Entities::TEXT_COMMON_INPUT_URL:
            case Entities::TEXT_COMMON_INPUT_URL_REQUIRED:
            case Entities::TEXT_COMMON_TEXTAREA:
            case Entities::TEXT_COMMON_CKEDITOR:
                return true;
            case Entities::TEXT_DISABLED:
                return Entities::DISABLED;
        }
        return false;

    }

    public function isAttrTranslatable($collectionAttr)
    {
        if (!$this->parentCollection)
            $this->parentCollection = $this->collection;

        switch ($this->parentCollection['option_' . $collectionAttr]) {
            case Collections::SEO_COMMON:
            case Collections::OPTION_FILE_TRANSLATABLE:
            case Collections::OPTION_NAME_TRANSLATABLE:
            case Collections::OPTION_CONTENT_TRANSLATABLE_TEXTAREA:
            case Collections::OPTION_CONTENT_TRANSLATABLE_CKEDITOR:
                return true;
            case Collections::SEO_DISABLED:
            case Collections::OPTION_FILE_DISABLED:
            case Collections::OPTION_NAME_DISABLED:
            case Collections::OPTION_CONTENT_DISABLED:
                return Collections::DISABLED;
        }
        return false;
    }

    public function getCollection()
    {
        return $this->hasOne(Collections::class, ['id' => 'collection_id']);
    }

    public function getItems()
    {
        return $this->hasMany(OaI::class, ['option_id' => 'id']);
    }
    
    public function getCreatedBy()
    {
        return $this->hasOne(Module::getInstance()->userClass, ['id' => 'created_by']);
    }


    public function getUpdatedBy()
    {
        return $this->hasOne(Module::getInstance()->userClass, ['id' => 'updated_by']);
    }

    public function requireValidator($type)
    {
        switch ($type) {
            case Entities::TEXT_COMMON_INPUT_STRING_REQUIRED:
            case Entities::TEXT_COMMON_INPUT_INT_REQUIRED:
            case Entities::TEXT_COMMON_INPUT_URL_REQUIRED:
            case Entities::TEXT_TRANSLATABLE_INPUT_STRING_REQUIRED:
            case Entities::TEXT_TRANSLATABLE_INPUT_INT_REQUIRED:
            case Entities::TEXT_TRANSLATABLE_INPUT_URL_REQUIRED:
                return true;
            default:
                return false;
        }
    }

    #endregion
}
