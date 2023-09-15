<?php

namespace afzalroq\cms\entities;

use afzalroq\cms\components\FileType;
use afzalroq\cms\interfaces\Linkable;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\caching\TagDependency;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Exception;

/**
 * This is the model class for table "cms_entities".
 *
 * @property int $id
 * @property string $slug
 * @property string $name_0
 * @property string $name_1
 * @property string $name_2
 * @property string $name_3
 * @property string $name_4
 * @property int|null $text_1
 * @property int|null $text_2
 * @property int|null $text_3
 * @property int|null $text_4
 * @property int|null $text_5
 * @property int|null $text_6
 * @property int|null $text_7
 * @property string|null $text_1_label
 * @property string|null $text_2_label
 * @property string|null $text_3_label
 * @property string|null $text_4_label
 * @property string|null $text_5_label
 * @property string|null $text_6_label
 * @property string|null $text_7_label
 * @property int|null $file_1
 * @property int|null $file_2
 * @property int|null $file_3
 * @property string|null $file_1_label
 * @property string|null $file_2_label
 * @property string|null $file_3_label
 * @property string|null $file_1_validator
 * @property string|null $file_2_validator
 * @property string|null $file_3_validator
 * @property int|null $use_date
 * @property int|null $use_status
 * @property int|null $use_seo
 * @property int|null $use_in_menu
 * @property int|null $use_gallery
 * @property int|null $use_views_count
 * @property int|null $manual_slug
 * @property int|null $disable_create_and_delete
 * @property int|null $use_watermark
 * @property int|null use_comments
 * @property int|null use_votes
 * @property int|null max_level
 * @property int|null use_moderation
 * @property int|null comment_without_login
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Items[] $items
 * @property CaE[] $caes
 */
class Entities extends ActiveRecord implements Linkable
{
    #region Constants
    #region TEXT types
    const DISABLED = -1;

    const TEXT_NULL = null;
    const TEXT_DISABLED = 0;
    const TEXT_COMMON_INPUT_STRING = 10;
    const TEXT_COMMON_INPUT_STRING_REQUIRED = 11;
    const TEXT_COMMON_INPUT_INT = 12;
    const TEXT_COMMON_INPUT_INT_REQUIRED = 13;
    const TEXT_COMMON_INPUT_URL = 14;
    const TEXT_COMMON_INPUT_URL_REQUIRED = 15;
    const TEXT_TRANSLATABLE_INPUT_STRING = 20;
    const TEXT_TRANSLATABLE_INPUT_STRING_REQUIRED = 21;
    const TEXT_TRANSLATABLE_INPUT_INT = 22;
    const TEXT_TRANSLATABLE_INPUT_INT_REQUIRED = 23;
    const TEXT_TRANSLATABLE_INPUT_URL = 24;
    const TEXT_TRANSLATABLE_INPUT_URL_REQUIRED = 25;
    const TEXT_COMMON_TEXTAREA = 31;
    const TEXT_COMMON_CKEDITOR = 32;
    const TEXT_TRANSLATABLE_TEXTAREA = 41;
    const TEXT_TRANSLATABLE_CKEDITOR = 42;
    #endregion
    #region FILE types
    const FILE_DISABLED = 0;
    const FILE_COMMON = 1;
    const FILE_TRANSLATABLE = 2;
    #endregion

    const USE_DATE_DISABLED = 0;
    const USE_DATE_DATE = 1;
    const USE_DATE_DATETIME = 2;
    const USE_TRANSLATABLE_DATE_DATE = 3;
    const USE_TRANSLATABLE_DATE_DATETIME = 4;

    #region seo types
    const SEO_DISABLED = 0;
    const SEO_COMMON = 1;
    const SEO_TRANSLATABLE = 2;
    #endregion seo types
    #endregion

    #commen section
    const COMMENT_OFF = 1;
    const COMMENT_ON = 2;
    const COMMENT_ON_REQUIRED = 3;

    public function isCommentsOn()
    {
        return in_array($this->use_comments, [self::COMMENT_ON, self::COMMENT_ON_REQUIRED]);
    }

    public function isVotesOn()
    {
        return in_array($this->use_votes, [self::COMMENT_ON, self::COMMENT_ON_REQUIRED]);
    }

    public function isTranslateble($field)
    {
        return in_array($this->{$field}, $this->translatableTextTypes());
    }

    private function translatableTextTypes()
    {
        return [
            self::TEXT_TRANSLATABLE_INPUT_STRING,
            self::TEXT_TRANSLATABLE_INPUT_STRING_REQUIRED,
            self::TEXT_TRANSLATABLE_INPUT_INT,
            self::TEXT_TRANSLATABLE_INPUT_INT_REQUIRED,
            self::TEXT_TRANSLATABLE_INPUT_URL,
            self::TEXT_TRANSLATABLE_INPUT_URL_REQUIRED,
            self::TEXT_TRANSLATABLE_TEXTAREA,
            self::TEXT_TRANSLATABLE_CKEDITOR
        ];
    }

    private function commonTextTypes()
    {
        return [
            self::TEXT_COMMON_INPUT_STRING,
            self::TEXT_COMMON_INPUT_STRING_REQUIRED,
            self::TEXT_COMMON_INPUT_INT,
            self::TEXT_COMMON_INPUT_INT_REQUIRED,
            self::TEXT_COMMON_INPUT_URL,
            self::TEXT_COMMON_INPUT_URL_REQUIRED,
            self::TEXT_COMMON_TEXTAREA,
            self::TEXT_COMMON_CKEDITOR
        ];
    }

    public function isCommonText($field)
    {
        return in_array($this->{$field}, $this->commonTextTypes());
    }

    public function hasCommonFiles()
    {
        return in_array(self::FILE_COMMON, [$this->file_1, $this->file_2, $this->file_3]);
    }

    public function hasCommonDate()
    {
        return in_array($this->use_date, [self::USE_DATE_DATE, self::USE_DATE_DATETIME]);
    }

    public function hasCommonTexts()
    {
        return $this->isCommonText('text_1') ||
            $this->isCommonText('text_2') ||
            $this->isCommonText('text_3') ||
            $this->isCommonText('text_4') ||
            $this->isCommonText('text_5') ||
            $this->isCommonText('text_6') ||
            $this->isCommonText('text_7');
    }

    public function isHaveHtmltags($field)
    {
        return $this->{$field} == self::TEXT_TRANSLATABLE_CKEDITOR;
    }

    #region Extra attributes
    public $file_1_mimeType;
    public $file_1_dimensionW;
    public $file_1_dimensionH;
    public $file_1_maxSize;
    public $file_2_mimeType;
    public $file_2_dimensionW;
    public $file_2_dimensionH;
    public $file_2_maxSize;
    public $file_3_mimeType;
    public $file_3_dimensionW;
    public $file_3_dimensionH;
    public $file_3_maxSize;
    private $cpId;
    #endregion

    #region Overrides Methods
    public static function tableName()
    {
        return 'cms_entities';
    }

    public static function textList()
    {
        return [
            self::TEXT_NULL => Yii::t('cms', 'Disabled'),

            self::TEXT_DISABLED => Yii::t('cms', 'Disabled'),

            self::TEXT_COMMON_INPUT_STRING =>
                Yii::t('cms', 'Common') . ' ' .
                Yii::t('cms', 'Input') . ' ' .
                Yii::t('cms', 'String'),

            self::TEXT_COMMON_INPUT_STRING_REQUIRED =>
                Yii::t('cms', 'Common') . ' ' .
                Yii::t('cms', 'Input') . ' ' .
                Yii::t('cms', 'String') . ' ' .
                Yii::t('cms', 'Required'),

            self::TEXT_COMMON_INPUT_INT =>
                Yii::t('cms', 'Common') . ' ' .
                Yii::t('cms', 'Input') . ' ' .
                Yii::t('cms', 'Integer'),

            self::TEXT_COMMON_INPUT_INT_REQUIRED =>
                Yii::t('cms', 'Common') . ' ' .
                Yii::t('cms', 'Input') . ' ' .
                Yii::t('cms', 'Integer') . ' ' .
                Yii::t('cms', 'Required'),

            self::TEXT_COMMON_INPUT_URL =>
                Yii::t('cms', 'Common') . ' ' .
                Yii::t('cms', 'Input') . ' ' .
                Yii::t('cms', 'Url'),

            self::TEXT_COMMON_INPUT_URL_REQUIRED =>
                Yii::t('cms', 'Common') . ' ' .
                Yii::t('cms', 'Input') . ' ' .
                Yii::t('cms', 'Url') . ' ' .
                Yii::t('cms', 'Required'),

            self::TEXT_TRANSLATABLE_INPUT_STRING =>
                Yii::t('cms', 'Translatable') . ' ' .
                Yii::t('cms', 'Input') . ' ' .
                Yii::t('cms', 'String'),

            self::TEXT_TRANSLATABLE_INPUT_STRING_REQUIRED =>
                Yii::t('cms', 'Translatable') . ' ' .
                Yii::t('cms', 'Input') . ' ' .
                Yii::t('cms', 'String') . ' ' .
                Yii::t('cms', 'Required'),

            self::TEXT_TRANSLATABLE_INPUT_INT =>
                Yii::t('cms', 'Translatable') . ' ' .
                Yii::t('cms', 'Input') . ' ' .
                Yii::t('cms', 'Integer'),

            self::TEXT_TRANSLATABLE_INPUT_INT_REQUIRED =>
                Yii::t('cms', 'Translatable') . ' ' .
                Yii::t('cms', 'Input') . ' ' .
                Yii::t('cms', 'Integer') . ' ' .
                Yii::t('cms', 'Required'),

            self::TEXT_TRANSLATABLE_INPUT_URL =>
                Yii::t('cms', 'Translatable') . ' ' .
                Yii::t('cms', 'Input') . ' ' .
                Yii::t('cms', 'Url'),

            self::TEXT_TRANSLATABLE_INPUT_URL_REQUIRED =>
                Yii::t('cms', 'Translatable') . ' ' .
                Yii::t('cms', 'Input') . ' ' .
                Yii::t('cms', 'Url') . ' ' .
                Yii::t('cms', 'Required'),

            self::TEXT_COMMON_TEXTAREA =>
                Yii::t('cms', 'Common') . ' ' .
                Yii::t('cms', 'Textarea'),

            self::TEXT_COMMON_CKEDITOR =>
                Yii::t('cms', 'Common') . ' ' .
                Yii::t('cms', 'Ckeditor'),

            self::TEXT_TRANSLATABLE_TEXTAREA =>
                Yii::t('cms', 'Translatable') . ' ' .
                Yii::t('cms', 'Textarea'),

            self::TEXT_TRANSLATABLE_CKEDITOR =>
                Yii::t('cms', 'Translatable') . ' ' .
                Yii::t('cms', 'Ckeditor'),

        ];
    }

    public static function fileList()
    {
        return [
            self::FILE_DISABLED => Yii::t('cms', 'Disabled'),
            self::FILE_COMMON => Yii::t('cms', 'Common'),
            self::FILE_TRANSLATABLE => Yii::t('cms', 'Translatable'),
        ];
    }

    public static function dateList()
    {
        return [
            self::USE_DATE_DISABLED => Yii::t('cms', 'Disabled'),
            self::USE_DATE_DATE => Yii::t('cms', 'Date'),
            self::USE_DATE_DATETIME => Yii::t('cms', 'Datetime'),
            self::USE_TRANSLATABLE_DATE_DATE => Yii::t('cms', 'Date translatable'),
            self::USE_TRANSLATABLE_DATE_DATETIME => Yii::t('cms', 'Datetime translatable'),
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class
        ];
    }

    public function beforeSave($insert)
    {

        $this->file_1_validator = [
            'mimeType' => $this->file_1_mimeType !== '' ? $this->file_1_mimeType : null,
            'dimensionW' => $this->file_1_dimensionW ?: null,
            'dimensionH' => $this->file_1_dimensionH ?: null,
            'maxSize' => $this->file_1_maxSize ?: null
        ];

        $this->file_2_validator = [
            'mimeType' => $this->file_2_mimeType !== '' ? $this->file_2_mimeType : null,
            'dimensionW' => $this->file_2_dimensionW ?: null,
            'dimensionH' => $this->file_2_dimensionH ?: null,
            'maxSize' => $this->file_2_maxSize ?: null
        ];
        $this->file_3_validator = [
            'mimeType' => $this->file_3_mimeType !== '' ? $this->file_3_mimeType : null,
            'dimensionW' => $this->file_3_dimensionW ?: null,
            'dimensionH' => $this->file_3_dimensionH ?: null,
            'maxSize' => $this->file_3_maxSize ?: null
        ];
        return parent::beforeSave($insert);
    }


    #endregion

    #region Extra methods

    public function afterFind()
    {
        if ($this->file_1_validator) {
            $this->file_1_mimeType = isset($this->file_1_validator['mimeType']) ? $this->file_1_validator['mimeType'] : "";
            $this->file_1_dimensionW = isset($this->file_1_validator['dimensionW']) ? $this->file_1_validator['dimensionW'] : "";
            $this->file_1_dimensionH = isset($this->file_1_validator['dimensionH']) ? $this->file_1_validator['dimensionH'] : "";
            $this->file_1_maxSize = isset($this->file_1_validator['maxSize']) ? $this->file_1_validator['maxSize'] : "";
        }
        if ($this->file_2_validator) {
            $this->file_2_mimeType = isset($this->file_2_validator['mimeType']) ? $this->file_2_validator['mimeType'] : "";
            $this->file_2_dimensionW = isset($this->file_2_validator['dimensionW']) ? $this->file_2_validator['dimensionW'] : "";
            $this->file_2_dimensionH = isset($this->file_2_validator['dimensionH']) ? $this->file_2_validator['dimensionH'] : "";
            $this->file_2_maxSize = isset($this->file_2_validator['maxSize']) ? $this->file_2_validator['maxSize'] : "";
        }
        if ($this->file_3_validator) {
            $this->file_3_mimeType = isset($this->file_3_validator['mimeType']) ? $this->file_3_validator['mimeType'] : "";
            $this->file_3_dimensionW = isset($this->file_3_validator['dimensionW']) ? $this->file_3_validator['dimensionW'] : "";
            $this->file_3_dimensionH = isset($this->file_3_validator['dimensionH']) ? $this->file_3_validator['dimensionH'] : "";
            $this->file_3_maxSize = isset($this->file_3_validator['maxSize']) ? $this->file_3_validator['maxSize'] : "";
        }
        parent::afterFind(); // TODO: Change the autogenerated stub
    }

    public function rules()
    {
        return [
            [['name_0', 'name_1', 'name_2', 'name_3', 'name_4'], 'string'],

            [['file_1_dimensionW', 'file_1_dimensionH', 'file_1_maxSize', 'file_2_dimensionW', 'file_2_dimensionH', 'file_2_maxSize', 'file_3_dimensionW', 'file_3_dimensionH', 'file_3_maxSize'], 'integer'],
            [['file_1_mimeType', 'file_2_mimeType', 'file_3_mimeType'], 'each', 'rule' => ['in', 'range' => array_keys(FileType::MIME_TYPES)]],
            [['file_1_mimeType', 'file_2_mimeType', 'file_3_mimeType'], 'checkMimeType'],


            [['text_1', 'text_2', 'text_3', 'text_4', 'text_5', 'text_6', 'text_7', 'file_1', 'file_2', 'file_3', 'use_date', 'use_status', 'use_in_menu', 'use_seo', 'use_gallery'], 'integer'],

            [['file_1_validator', 'file_2_validator', 'file_3_validator'], 'safe'],

            [['slug', 'text_1_label', 'text_2_label', 'text_3_label', 'text_4_label', 'text_5_label', 'text_6_label', 'text_7_label', 'file_1_label', 'file_2_label', 'file_3_label'], 'string', 'max' => 255],

            [['use_date', 'use_seo', 'use_gallery', 'use_in_menu', 'use_status', 'use_views_count', 'manual_slug'], 'required'],
            [['use_date', 'use_seo', 'use_gallery', 'use_in_menu', 'use_status', 'use_views_count', 'manual_slug', 'disable_create_and_delete', 'use_watermark'], 'integer'],

            [['slug'], 'required'],
            [['slug'], 'unique'],
            [['slug'], 'afzalroq\cms\validators\SlugValidator'],

            // comment section uchun qo'shilgan maydonlar
            [['comment_without_login', 'use_moderation'], 'boolean'],
            [['max_level', 'use_votes', 'use_comments'], 'integer'],
            [['max_level', 'use_comments', 'use_votes'], 'default', 'value' => self::COMMENT_OFF],
            [['use_votes', 'use_comments'], 'in', 'range' => [self::COMMENT_ON, self::COMMENT_OFF, self::COMMENT_ON_REQUIRED]],
        ];
    }

    public function either($attribute_name, $params)
    {
        $field1 = $this->getAttributeLabel($attribute_name);
        $field2 = $this->getAttributeLabel($params['other']);
        if (empty($this->$attribute_name) && empty($this->{$params['other']})) {
            $this->addError($attribute_name, Yii::t('yii', "either {$field1} or {$field2} is required."));
        }
    }

    public function checkMimeType($attribute, $params)
    {
        if (($attribute == 'file_1_mimeType') && !empty($this->file_1_mimeType) && (count($this->file_1_mimeType) > 1 && in_array(2, $this->file_1_mimeType))) {
            $this->addError($attribute, $attribute . ' ' . Yii::t('cms', 'If the SVG format is used in the file, no other format can be used'));
        }
        if (($attribute == 'file_2_mimeType') && !empty($this->file_2_mimeType) && (count($this->file_2_mimeType) > 1 && in_array(2, $this->file_2_mimeType))) {
            $this->addError($attribute, $attribute . ' ' . Yii::t('cms', 'If the SVG format is used in the file, no other format can be used'));
        }
        if (($attribute == 'file_3_mimeType') && !empty($this->file_3_mimeType) && (count($this->file_3_mimeType) > 1 && in_array(2, $this->file_3_mimeType))) {
            $this->addError($attribute, $attribute . ' ' . Yii::t('cms', 'If the SVG format is used in the file, no other format can be used'));
        }
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
            'text_1' => Yii::t('cms', 'Text 1'),
            'text_2' => Yii::t('cms', 'Text 2'),
            'text_3' => Yii::t('cms', 'Text 3'),
            'text_4' => Yii::t('cms', 'Text 4'),
            'text_5' => Yii::t('cms', 'Text 5'),
            'text_6' => Yii::t('cms', 'Text 6'),
            'text_7' => Yii::t('cms', 'Text 7'),
            'text_1_label' => Yii::t('cms', 'Text 1 label'),
            'text_2_label' => Yii::t('cms', 'Text 2 label'),
            'text_3_label' => Yii::t('cms', 'Text 3 label'),
            'text_4_label' => Yii::t('cms', 'Text 4 label'),
            'text_5_label' => Yii::t('cms', 'Text 5 label'),
            'text_6_label' => Yii::t('cms', 'Text 6 label'),
            'text_7_label' => Yii::t('cms', 'Text 7 label'),
            'file_1' => Yii::t('cms', 'File 1'),
            'file_2' => Yii::t('cms', 'File 2'),
            'file_3' => Yii::t('cms', 'File 3'),
            'file_1_label' => Yii::t('cms', 'File 1 label'),
            'file_2_label' => Yii::t('cms', 'File 2 label'),
            'file_3_label' => Yii::t('cms', 'File 3 label'),
            'file_1_maxSize' => Yii::t('cms', 'File 1 max size (mb)'),
            'file_2_maxSize' => Yii::t('cms', 'File 2 max size (mb)'),
            'file_3_maxSize' => Yii::t('cms', 'File 3 max size (mb)'),
            'use_date' => Yii::t('cms', 'Use date'),
            'use_status' => Yii::t('cms', 'Use status'),
            'use_in_menu' => Yii::t('cms', 'Use in menu'),
            'use_seo' => Yii::t('cms', 'Use SEO'),
            'use_gallery' => Yii::t('cms', 'Use Gallery'),
            'use_views_count' => Yii::t('cms', 'Use Views Count'),
            'manual_slug' => Yii::t('cms', 'Manual slug'),
            'disable_create_and_delete' => Yii::t('cms', 'Disable create and delete'),
            'use_watermark' => Yii::t('cms', 'Use watermark'),
            'created_at' => Yii::t('cms', 'Created at'),
            'updated_at' => Yii::t('cms', 'Updated at'),

            'use_comments' => Yii::t('cms', 'Use comment'),
            'use_votes' => Yii::t('cms', 'Use votes'),
            'max_level' => Yii::t('cms', 'Max level'),
            'use_moderation' => Yii::t('cms', 'Use moderation'),
            'comment_without_login' => Yii::t('cms', 'Can Comment without login'),
        ];
    }

    public function textAndFileAttrs()
    {
        $entity_text_attrs = [];
        $entity_file_attrs = [];
        $seo_attrs = ['meta_des', 'meta_keyword'];
        foreach ($this->attributes as $attr => $value) {
            if (preg_match('/^text_[1-7]$/', $attr))
                $entity_text_attrs[$attr] = $value;
            if (preg_match('/^file_[1-3]$/', $attr))
                $entity_file_attrs[$attr] = $value;
        }
        return [
            $entity_text_attrs,
            $entity_file_attrs,
            $seo_attrs
        ];

    }

    public function getName($key = null)
    {
        $key = isset($key) ? $key : \Yii::$app->language;

        if (is_string($key)) {
            $key = \Yii::$app->params['cms']['languageIds'][$key];
        }
        return $this['name_' . $key];
    }

    /**
     * Gets query for [[Items]].
     *
     * @return ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(Items::class, ['entity_id' => 'id']);
    }

    /**
     * Gets query for [[CaE]].
     *
     * @return ActiveQuery
     */
    public function getCaes()
    {
        return $this->hasMany(CaE::class, ['entity_id' => 'id'])->orderBy('sort');
    }

    #endregion

    public function beforeDelete()
    {
        $this->cpId = $this->id;
        return parent::beforeDelete(); // TODO: Change the autogenerated stub
    }

    public function afterDelete()
    {
        parent::afterDelete();

        TagDependency::invalidate(Yii::$app->{Yii::$app->getModule('cms')->cache}, 'entities_' . $this->slug);

        foreach (Menu::find()->all() as $menu) {
            if ($menu->type !== Menu::TYPE_ENTITY)
                continue;
            if ($menu->type_helper != $this->cpId)
                continue;

            if (!$menu->delete())
                throw new Exception("Cannot delete id: {$menu->id} of menu");
        }
    }

    public function getLink(): string
    {
        return '/e/' . $this->slug;
    }

    public static function getCommentTextUseOrNot()
    {
        return [
            self::COMMENT_OFF => Yii::t('cms', 'Disabled'),
            self::COMMENT_ON => Yii::t('cms', 'Comment On'),
            self::COMMENT_ON_REQUIRED => Yii::t('cms', 'Comment On and required'),
        ];
    }
}

use yii\caching\TagDependency;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Exception;

/**
 * This is the model class for table "cms_entities".
 *
 * @property int $id
 * @property string $slug
 * @property string $name_0
 * @property string $name_1
 * @property string $name_2
 * @property string $name_3
 * @property string $name_4
 * @property int|null $text_1
 * @property int|null $text_2
 * @property int|null $text_3
 * @property int|null $text_4
 * @property int|null $text_5
 * @property int|null $text_6
 * @property int|null $text_7
 * @property string|null $text_1_label
 * @property string|null $text_2_label
 * @property string|null $text_3_label
 * @property string|null $text_4_label
 * @property string|null $text_5_label
 * @property string|null $text_6_label
 * @property string|null $text_7_label
 * @property int|null $file_1
 * @property int|null $file_2
 * @property int|null $file_3
 * @property string|null $file_1_label
 * @property string|null $file_2_label
 * @property string|null $file_3_label
 * @property string|null $file_1_validator
 * @property string|null $file_2_validator
 * @property string|null $file_3_validator
 * @property int|null $use_date
 * @property int|null $use_status
 * @property int|null $use_seo
 * @property int|null $use_in_menu
 * @property int|null $use_gallery
 * @property int|null $use_views_count
 * @property int|null $manual_slug
 * @property int|null $disable_create_and_delete
 * @property int|null $use_watermark
 * @property int|null use_comments
 * @property int|null use_votes
 * @property int|null max_level
 * @property int|null use_moderation
 * @property int|null comment_without_login
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Items[] $items
 * @property CaE[] $caes
 */
class Entities extends ActiveRecord implements Linkable
{
    #region Constants
    #region TEXT types
    const DISABLED = -1;

    const TEXT_NULL = null;
    const TEXT_DISABLED = 0;
    const TEXT_COMMON_INPUT_STRING = 10;
    const TEXT_COMMON_INPUT_STRING_REQUIRED = 11;
    const TEXT_COMMON_INPUT_INT = 12;
    const TEXT_COMMON_INPUT_INT_REQUIRED = 13;
    const TEXT_COMMON_INPUT_URL = 14;
    const TEXT_COMMON_INPUT_URL_REQUIRED = 15;
    const TEXT_TRANSLATABLE_INPUT_STRING = 20;
    const TEXT_TRANSLATABLE_INPUT_STRING_REQUIRED = 21;
    const TEXT_TRANSLATABLE_INPUT_INT = 22;
    const TEXT_TRANSLATABLE_INPUT_INT_REQUIRED = 23;
    const TEXT_TRANSLATABLE_INPUT_URL = 24;
    const TEXT_TRANSLATABLE_INPUT_URL_REQUIRED = 25;
    const TEXT_COMMON_TEXTAREA = 31;
    const TEXT_COMMON_CKEDITOR = 32;
    const TEXT_TRANSLATABLE_TEXTAREA = 41;
    const TEXT_TRANSLATABLE_CKEDITOR = 42;
    #endregion
    #region FILE types
    const FILE_DISABLED = 0;
    const FILE_COMMON = 1;
    const FILE_TRANSLATABLE = 2;
    #endregion

    const USE_DATE_DISABLED = 0;
    const USE_DATE_DATE = 1;
    const USE_DATE_DATETIME = 2;
    const USE_TRANSLATABLE_DATE_DATE = 3;
    const USE_TRANSLATABLE_DATE_DATETIME = 4;

    #region seo types
    const SEO_DISABLED = 0;
    const SEO_COMMON = 1;
    const SEO_TRANSLATABLE = 2;
    #endregion seo types
    #endregion

    #commen section
    const COMMENT_OFF = 1;
    const COMMENT_ON = 2;
    const COMMENT_ON_REQUIRED = 3;

    public function isCommentsOn()
    {
        return in_array($this->use_comments, [self::COMMENT_ON, self::COMMENT_ON_REQUIRED]);
    }

    public function isVotesOn()
    {
        return in_array($this->use_votes, [self::COMMENT_ON, self::COMMENT_ON_REQUIRED]);
    }

    public function isTranslateble($field)
    {
        return in_array($this->{$field}, $this->translatableTextTypes());
    }

    private function translatableTextTypes()
    {
        return [
            self::TEXT_TRANSLATABLE_INPUT_STRING,
            self::TEXT_TRANSLATABLE_INPUT_STRING_REQUIRED,
            self::TEXT_TRANSLATABLE_INPUT_INT,
            self::TEXT_TRANSLATABLE_INPUT_INT_REQUIRED,
            self::TEXT_TRANSLATABLE_INPUT_URL,
            self::TEXT_TRANSLATABLE_INPUT_URL_REQUIRED,
            self::TEXT_TRANSLATABLE_TEXTAREA,
            self::TEXT_TRANSLATABLE_CKEDITOR
        ];
    }

    private function commonTextTypes()
    {
        return [
            self::TEXT_COMMON_INPUT_STRING,
            self::TEXT_COMMON_INPUT_STRING_REQUIRED,
            self::TEXT_COMMON_INPUT_INT,
            self::TEXT_COMMON_INPUT_INT_REQUIRED,
            self::TEXT_COMMON_INPUT_URL,
            self::TEXT_COMMON_INPUT_URL_REQUIRED,
            self::TEXT_COMMON_TEXTAREA,
            self::TEXT_COMMON_CKEDITOR
        ];
    }

    public function isCommonText($field)
    {
        return in_array($this->{$field}, $this->commonTextTypes());
    }

    public function hasCommonFiles()
    {
        return in_array(self::FILE_COMMON, [$this->file_1, $this->file_2, $this->file_3]);
    }

    public function hasCommonDate()
    {
        return in_array($this->use_date, [self::USE_DATE_DATE, self::USE_DATE_DATETIME]);
    }

    public function hasCommonTexts()
    {
        return $this->isCommonText('text_1') ||
            $this->isCommonText('text_2') ||
            $this->isCommonText('text_3') ||
            $this->isCommonText('text_4') ||
            $this->isCommonText('text_5') ||
            $this->isCommonText('text_6') ||
            $this->isCommonText('text_7');
    }

    public function isHaveHtmltags($field)
    {
        return $this->{$field} == self::TEXT_TRANSLATABLE_CKEDITOR;
    }

    #region Extra attributes
    public $file_1_mimeType;
    public $file_1_dimensionW;
    public $file_1_dimensionH;
    public $file_1_maxSize;
    public $file_2_mimeType;
    public $file_2_dimensionW;
    public $file_2_dimensionH;
    public $file_2_maxSize;
    public $file_3_mimeType;
    public $file_3_dimensionW;
    public $file_3_dimensionH;
    public $file_3_maxSize;
    private $cpId;
    #endregion

    #region Overrides Methods
    public static function tableName()
    {
        return 'cms_entities';
    }

    public static function textList()
    {
        return [
            self::TEXT_NULL => Yii::t('cms', 'Disabled'),

            self::TEXT_DISABLED => Yii::t('cms', 'Disabled'),

            self::TEXT_COMMON_INPUT_STRING =>
                Yii::t('cms', 'Common') . ' ' .
                Yii::t('cms', 'Input') . ' ' .
                Yii::t('cms', 'String'),

            self::TEXT_COMMON_INPUT_STRING_REQUIRED =>
                Yii::t('cms', 'Common') . ' ' .
                Yii::t('cms', 'Input') . ' ' .
                Yii::t('cms', 'String') . ' ' .
                Yii::t('cms', 'Required'),

            self::TEXT_COMMON_INPUT_INT =>
                Yii::t('cms', 'Common') . ' ' .
                Yii::t('cms', 'Input') . ' ' .
                Yii::t('cms', 'Integer'),

            self::TEXT_COMMON_INPUT_INT_REQUIRED =>
                Yii::t('cms', 'Common') . ' ' .
                Yii::t('cms', 'Input') . ' ' .
                Yii::t('cms', 'Integer') . ' ' .
                Yii::t('cms', 'Required'),

            self::TEXT_COMMON_INPUT_URL =>
                Yii::t('cms', 'Common') . ' ' .
                Yii::t('cms', 'Input') . ' ' .
                Yii::t('cms', 'Url'),

            self::TEXT_COMMON_INPUT_URL_REQUIRED =>
                Yii::t('cms', 'Common') . ' ' .
                Yii::t('cms', 'Input') . ' ' .
                Yii::t('cms', 'Url') . ' ' .
                Yii::t('cms', 'Required'),

            self::TEXT_TRANSLATABLE_INPUT_STRING =>
                Yii::t('cms', 'Translatable') . ' ' .
                Yii::t('cms', 'Input') . ' ' .
                Yii::t('cms', 'String'),

            self::TEXT_TRANSLATABLE_INPUT_STRING_REQUIRED =>
                Yii::t('cms', 'Translatable') . ' ' .
                Yii::t('cms', 'Input') . ' ' .
                Yii::t('cms', 'String') . ' ' .
                Yii::t('cms', 'Required'),

            self::TEXT_TRANSLATABLE_INPUT_INT =>
                Yii::t('cms', 'Translatable') . ' ' .
                Yii::t('cms', 'Input') . ' ' .
                Yii::t('cms', 'Integer'),

            self::TEXT_TRANSLATABLE_INPUT_INT_REQUIRED =>
                Yii::t('cms', 'Translatable') . ' ' .
                Yii::t('cms', 'Input') . ' ' .
                Yii::t('cms', 'Integer') . ' ' .
                Yii::t('cms', 'Required'),

            self::TEXT_TRANSLATABLE_INPUT_URL =>
                Yii::t('cms', 'Translatable') . ' ' .
                Yii::t('cms', 'Input') . ' ' .
                Yii::t('cms', 'Url'),

            self::TEXT_TRANSLATABLE_INPUT_URL_REQUIRED =>
                Yii::t('cms', 'Translatable') . ' ' .
                Yii::t('cms', 'Input') . ' ' .
                Yii::t('cms', 'Url') . ' ' .
                Yii::t('cms', 'Required'),

            self::TEXT_COMMON_TEXTAREA =>
                Yii::t('cms', 'Common') . ' ' .
                Yii::t('cms', 'Textarea'),

            self::TEXT_COMMON_CKEDITOR =>
                Yii::t('cms', 'Common') . ' ' .
                Yii::t('cms', 'Ckeditor'),

            self::TEXT_TRANSLATABLE_TEXTAREA =>
                Yii::t('cms', 'Translatable') . ' ' .
                Yii::t('cms', 'Textarea'),

            self::TEXT_TRANSLATABLE_CKEDITOR =>
                Yii::t('cms', 'Translatable') . ' ' .
                Yii::t('cms', 'Ckeditor'),

        ];
    }

    public static function fileList()
    {
        return [
            self::FILE_DISABLED => Yii::t('cms', 'Disabled'),
            self::FILE_COMMON => Yii::t('cms', 'Common'),
            self::FILE_TRANSLATABLE => Yii::t('cms', 'Translatable'),
        ];
    }

    public static function dateList()
    {
        return [
            self::USE_DATE_DISABLED => Yii::t('cms', 'Disabled'),
            self::USE_DATE_DATE => Yii::t('cms', 'Date'),
            self::USE_DATE_DATETIME => Yii::t('cms', 'Datetime'),
            self::USE_TRANSLATABLE_DATE_DATE => Yii::t('cms', 'Date translatable'),
            self::USE_TRANSLATABLE_DATE_DATETIME => Yii::t('cms', 'Datetime translatable'),
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class
        ];
    }

    public function beforeSave($insert)
    {

        $this->file_1_validator = [
            'mimeType' => $this->file_1_mimeType !== '' ? $this->file_1_mimeType : null,
            'dimensionW' => $this->file_1_dimensionW ?: null,
            'dimensionH' => $this->file_1_dimensionH ?: null,
            'maxSize' => $this->file_1_maxSize ?: null
        ];

        $this->file_2_validator = [
            'mimeType' => $this->file_2_mimeType !== '' ? $this->file_2_mimeType : null,
            'dimensionW' => $this->file_2_dimensionW ?: null,
            'dimensionH' => $this->file_2_dimensionH ?: null,
            'maxSize' => $this->file_2_maxSize ?: null
        ];
        $this->file_3_validator = [
            'mimeType' => $this->file_3_mimeType !== '' ? $this->file_3_mimeType : null,
            'dimensionW' => $this->file_3_dimensionW ?: null,
            'dimensionH' => $this->file_3_dimensionH ?: null,
            'maxSize' => $this->file_3_maxSize ?: null
        ];
        return parent::beforeSave($insert);
    }


    #endregion

    #region Extra methods

    public function afterFind()
    {
        if ($this->file_1_validator) {
            $this->file_1_mimeType = isset($this->file_1_validator['mimeType']) ? $this->file_1_validator['mimeType'] : "";
            $this->file_1_dimensionW = isset($this->file_1_validator['dimensionW']) ? $this->file_1_validator['dimensionW'] : "";
            $this->file_1_dimensionH = isset($this->file_1_validator['dimensionH']) ? $this->file_1_validator['dimensionH'] : "";
            $this->file_1_maxSize = isset($this->file_1_validator['maxSize']) ? $this->file_1_validator['maxSize'] : "";
        }
        if ($this->file_2_validator) {
            $this->file_2_mimeType = isset($this->file_2_validator['mimeType']) ? $this->file_2_validator['mimeType'] : "";
            $this->file_2_dimensionW = isset($this->file_2_validator['dimensionW']) ? $this->file_2_validator['dimensionW'] : "";
            $this->file_2_dimensionH = isset($this->file_2_validator['dimensionH']) ? $this->file_2_validator['dimensionH'] : "";
            $this->file_2_maxSize = isset($this->file_2_validator['maxSize']) ? $this->file_2_validator['maxSize'] : "";
        }
        if ($this->file_3_validator) {
            $this->file_3_mimeType = isset($this->file_3_validator['mimeType']) ? $this->file_3_validator['mimeType'] : "";
            $this->file_3_dimensionW = isset($this->file_3_validator['dimensionW']) ? $this->file_3_validator['dimensionW'] : "";
            $this->file_3_dimensionH = isset($this->file_3_validator['dimensionH']) ? $this->file_3_validator['dimensionH'] : "";
            $this->file_3_maxSize = isset($this->file_3_validator['maxSize']) ? $this->file_3_validator['maxSize'] : "";
        }
        parent::afterFind(); // TODO: Change the autogenerated stub
    }

    public function rules()
    {
        return [
            [['name_0', 'name_1', 'name_2', 'name_3', 'name_4'], 'string'],

            [['file_1_dimensionW', 'file_1_dimensionH', 'file_1_maxSize', 'file_2_dimensionW', 'file_2_dimensionH', 'file_2_maxSize', 'file_3_dimensionW', 'file_3_dimensionH', 'file_3_maxSize'], 'integer'],
            [['file_1_mimeType', 'file_2_mimeType', 'file_3_mimeType'], 'each', 'rule' => ['in', 'range' => array_keys(FileType::MIME_TYPES)]],
            [['file_1_mimeType', 'file_2_mimeType', 'file_3_mimeType'], 'checkMimeType'],


            [['text_1', 'text_2', 'text_3', 'text_4', 'text_5', 'text_6', 'text_7', 'file_1', 'file_2', 'file_3', 'use_date', 'use_status', 'use_in_menu', 'use_seo', 'use_gallery'], 'integer'],

            [['file_1_validator', 'file_2_validator', 'file_3_validator'], 'safe'],

            [['slug', 'text_1_label', 'text_2_label', 'text_3_label', 'text_4_label', 'text_5_label', 'text_6_label', 'text_7_label', 'file_1_label', 'file_2_label', 'file_3_label'], 'string', 'max' => 255],

            [['use_date', 'use_seo', 'use_gallery', 'use_in_menu', 'use_status', 'use_views_count', 'manual_slug'], 'required'],
            [['use_date', 'use_seo', 'use_gallery', 'use_in_menu', 'use_status', 'use_views_count', 'manual_slug', 'disable_create_and_delete', 'use_watermark'], 'integer'],

            [['slug'], 'required'],
            [['slug'], 'unique'],
            [['slug'], 'afzalroq\cms\validators\SlugValidator'],

            // comment section uchun qo'shilgan maydonlar
            [['comment_without_login', 'use_moderation'], 'boolean'],
            [['max_level', 'use_votes', 'use_comments'], 'integer'],
            [['max_level', 'use_comments', 'use_votes'], 'default', 'value' => self::COMMENT_OFF],
            [['use_votes', 'use_comments'], 'in', 'range' => [self::COMMENT_ON, self::COMMENT_OFF, self::COMMENT_ON_REQUIRED]],
        ];
    }

    public function either($attribute_name, $params)
    {
        $field1 = $this->getAttributeLabel($attribute_name);
        $field2 = $this->getAttributeLabel($params['other']);
        if (empty($this->$attribute_name) && empty($this->{$params['other']})) {
            $this->addError($attribute_name, Yii::t('yii', "either {$field1} or {$field2} is required."));
        }
    }

    public function checkMimeType($attribute, $params)
    {
        if (($attribute == 'file_1_mimeType') && !empty($this->file_1_mimeType) && (count($this->file_1_mimeType) > 1 && in_array(2, $this->file_1_mimeType))) {
            $this->addError($attribute, $attribute . ' ' . Yii::t('cms', 'If the SVG format is used in the file, no other format can be used'));
        }
        if (($attribute == 'file_2_mimeType') && !empty($this->file_2_mimeType) && (count($this->file_2_mimeType) > 1 && in_array(2, $this->file_2_mimeType))) {
            $this->addError($attribute, $attribute . ' ' . Yii::t('cms', 'If the SVG format is used in the file, no other format can be used'));
        }
        if (($attribute == 'file_3_mimeType') && !empty($this->file_3_mimeType) && (count($this->file_3_mimeType) > 1 && in_array(2, $this->file_3_mimeType))) {
            $this->addError($attribute, $attribute . ' ' . Yii::t('cms', 'If the SVG format is used in the file, no other format can be used'));
        }
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
            'text_1' => Yii::t('cms', 'Text 1'),
            'text_2' => Yii::t('cms', 'Text 2'),
            'text_3' => Yii::t('cms', 'Text 3'),
            'text_4' => Yii::t('cms', 'Text 4'),
            'text_5' => Yii::t('cms', 'Text 5'),
            'text_6' => Yii::t('cms', 'Text 6'),
            'text_7' => Yii::t('cms', 'Text 7'),
            'text_1_label' => Yii::t('cms', 'Text 1 label'),
            'text_2_label' => Yii::t('cms', 'Text 2 label'),
            'text_3_label' => Yii::t('cms', 'Text 3 label'),
            'text_4_label' => Yii::t('cms', 'Text 4 label'),
            'text_5_label' => Yii::t('cms', 'Text 5 label'),
            'text_6_label' => Yii::t('cms', 'Text 6 label'),
            'text_7_label' => Yii::t('cms', 'Text 7 label'),
            'file_1' => Yii::t('cms', 'File 1'),
            'file_2' => Yii::t('cms', 'File 2'),
            'file_3' => Yii::t('cms', 'File 3'),
            'file_1_label' => Yii::t('cms', 'File 1 label'),
            'file_2_label' => Yii::t('cms', 'File 2 label'),
            'file_3_label' => Yii::t('cms', 'File 3 label'),
            'file_1_maxSize' => Yii::t('cms', 'File 1 max size (mb)'),
            'file_2_maxSize' => Yii::t('cms', 'File 2 max size (mb)'),
            'file_3_maxSize' => Yii::t('cms', 'File 3 max size (mb)'),
            'use_date' => Yii::t('cms', 'Use date'),
            'use_status' => Yii::t('cms', 'Use status'),
            'use_in_menu' => Yii::t('cms', 'Use in menu'),
            'use_seo' => Yii::t('cms', 'Use SEO'),
            'use_gallery' => Yii::t('cms', 'Use Gallery'),
            'use_views_count' => Yii::t('cms', 'Use Views Count'),
            'manual_slug' => Yii::t('cms', 'Manual slug'),
            'disable_create_and_delete' => Yii::t('cms', 'Disable create and delete'),
            'use_watermark' => Yii::t('cms', 'Use watermark'),
            'created_at' => Yii::t('cms', 'Created at'),
            'updated_at' => Yii::t('cms', 'Updated at'),

            'use_comments' => Yii::t('cms', 'Use comment'),
            'use_votes' => Yii::t('cms', 'Use votes'),
            'max_level' => Yii::t('cms', 'Max level'),
            'use_moderation' => Yii::t('cms', 'Use moderation'),
            'comment_without_login' => Yii::t('cms', 'Can Comment without login'),
        ];
    }

    public function textAndFileAttrs()
    {
        $entity_text_attrs = [];
        $entity_file_attrs = [];
        $seo_attrs = ['meta_des', 'meta_keyword'];
        foreach ($this->attributes as $attr => $value) {
            if (preg_match('/^text_[1-7]$/', $attr))
                $entity_text_attrs[$attr] = $value;
            if (preg_match('/^file_[1-3]$/', $attr))
                $entity_file_attrs[$attr] = $value;
        }
        return [
            $entity_text_attrs,
            $entity_file_attrs,
            $seo_attrs
        ];

    }

    public function getName($key = null)
    {
        $key = isset($key) ? $key : \Yii::$app->language;

        if (is_string($key)) {
            $key = \Yii::$app->params['cms']['languageIds'][$key];
        }
        return $this['name_' . $key];
    }

    /**
     * Gets query for [[Items]].
     *
     * @return ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(Items::class, ['entity_id' => 'id']);
    }

    /**
     * Gets query for [[CaE]].
     *
     * @return ActiveQuery
     */
    public function getCaes()
    {
        return $this->hasMany(CaE::class, ['entity_id' => 'id'])->orderBy('sort');
    }

    #endregion

    public function beforeDelete()
    {
        $this->cpId = $this->id;
        return parent::beforeDelete(); // TODO: Change the autogenerated stub
    }

    public function afterDelete()
    {
        parent::afterDelete();

        TagDependency::invalidate(Yii::$app->{Yii::$app->getModule('cms')->cache}, 'entities_' . $this->slug);

        foreach (Menu::find()->all() as $menu) {
            if ($menu->type !== Menu::TYPE_ENTITY)
                continue;
            if ($menu->type_helper != $this->cpId)
                continue;

            if (!$menu->delete())
                throw new Exception("Cannot delete id: {$menu->id} of menu");
        }
    }

    public function getLink(): string
    {
        return '/e/' . $this->slug;
    }

    public static function getCommentTextUseOrNot()
    {
        return [
            self::COMMENT_OFF => Yii::t('cms', 'Disabled'),
            self::COMMENT_ON => Yii::t('cms', 'Comment On'),
            self::COMMENT_ON_REQUIRED => Yii::t('cms', 'Comment On and required'),
        ];
    }
}
