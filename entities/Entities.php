<?php

namespace abdualiym\cms\entities;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "cms_entities".
 *
 * @property int         $id
 * @property string      $slug
 * @property int|null    $text_1
 * @property int|null    $text_2
 * @property int|null    $text_3
 * @property int|null    $text_4
 * @property int|null    $text_5
 * @property int|null    $text_6
 * @property int|null    $text_7
 * @property string|null $text_1_label
 * @property string|null $text_2_label
 * @property string|null $text_3_label
 * @property string|null $text_4_label
 * @property string|null $text_5_label
 * @property string|null $text_6_label
 * @property string|null $text_7_label
 * @property int|null    $file_1
 * @property int|null    $file_2
 * @property int|null    $file_3
 * @property string|null $file_1_label
 * @property string|null $file_2_label
 * @property string|null $file_3_label
 * @property string|null $file_1_validator
 * @property string|null $file_2_validator
 * @property string|null $file_3_validator
 * @property int|null    $use_date
 * @property int|null    $use_status
 * @property int         $created_at
 * @property int         $updated_at
 *
 * @property Items[]     $items
 * @property CaE[]       $caes
 */
class Entities extends \yii\db\ActiveRecord
{
    #region TEXT types
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

    public function textAFileAttrs()
    {
        $entity_text_attrs = [];
        $entity_file_attrs = [];
        foreach($this->attributes as $attr => $value) {
            if(preg_match('/^text_[1-7]$/', $attr))
                $entity_text_attrs[$attr] = $value;
            if(preg_match('/^file_[1-3]$/', $attr))
                $entity_file_attrs[$attr] = $value;
        }

        return [
            $entity_text_attrs,
            $entity_file_attrs,
        ];

    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cms_entities';
    }

    public static function textList()
    {
        return [
            self::TEXT_DISABLED => Yii::t('cms', 'Disabled'),
            self::TEXT_COMMON_INPUT_STRING => Yii::t('cms', 'Common input string'),
            self::TEXT_COMMON_INPUT_STRING_REQUIRED => Yii::t('cms', 'Common input string required'),
            self::TEXT_COMMON_INPUT_INT => Yii::t('cms', 'Common input int'),
            self::TEXT_COMMON_INPUT_INT_REQUIRED => Yii::t('cms', 'Common input int required'),
            self::TEXT_COMMON_INPUT_URL => Yii::t('cms', 'Common input url'),
            self::TEXT_COMMON_INPUT_URL_REQUIRED => Yii::t('cms', 'Common input url required'),
            self::TEXT_TRANSLATABLE_INPUT_STRING => Yii::t('cms', 'Translatable input string'),
            self::TEXT_TRANSLATABLE_INPUT_STRING_REQUIRED => Yii::t('cms', 'Translatable input string required'),
            self::TEXT_TRANSLATABLE_INPUT_INT => Yii::t('cms', 'Translatable input int'),
            self::TEXT_TRANSLATABLE_INPUT_INT_REQUIRED => Yii::t('cms', 'Translatable input int required'),
            self::TEXT_TRANSLATABLE_INPUT_URL => Yii::t('cms', 'Translatable input url'),
            self::TEXT_TRANSLATABLE_INPUT_URL_REQUIRED => Yii::t('cms', 'Translatable input url required'),
            self::TEXT_COMMON_TEXTAREA => Yii::t('cms', 'Common textarea'),
            self::TEXT_COMMON_CKEDITOR => Yii::t('cms', 'Common ckeditor'),
            self::TEXT_TRANSLATABLE_TEXTAREA => Yii::t('cms', 'Translatable textarea'),
            self::TEXT_TRANSLATABLE_CKEDITOR => Yii::t('cms', 'Translatable ckeditor'),
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
        ];
    }

    public function beforeSave($insert)
    {
        $this->file_1_validator = [
            'mimeType' => $this->file_1_mimeType !== '' ? $this->file_1_mimeType : null,
            'dimensionW' => $this->file_1_dimensionW ? : null,
            'dimensionH' => $this->file_1_dimensionH ? : null,
            'maxSize' => $this->file_1_maxSize ? : null
        ];

        $this->file_2_validator = [
            'mimeType' => $this->file_2_mimeType !== '' ? $this->file_2_mimeType : null,
            'dimensionW' => $this->file_2_dimensionW ? : null,
            'dimensionH' => $this->file_2_dimensionH ? : null,
            'maxSize' => $this->file_2_maxSize ? : null
        ];
        $this->file_3_validator = [
            'mimeType' => $this->file_3_mimeType !== '' ? $this->file_3_mimeType : null,
            'dimensionW' => $this->file_3_dimensionW ? : null,
            'dimensionH' => $this->file_3_dimensionH ? : null,
            'maxSize' => $this->file_3_maxSize ? : null
        ];
        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        if($this->file_1_validator) {
            $this->file_1_mimeType = $this->file_1_validator['mimeType'];
            $this->file_1_dimensionW = $this->file_1_validator['dimensionW'];
            $this->file_1_dimensionH = $this->file_1_validator['dimensionH'];
            $this->file_1_maxSize = $this->file_1_validator['maxSize'];
        }
        if($this->file_2_validator) {
            $this->file_2_mimeType = $this->file_2_validator['mimeType'];
            $this->file_2_dimensionW = $this->file_2_validator['dimensionW'];
            $this->file_2_dimensionH = $this->file_2_validator['dimensionH'];
            $this->file_2_maxSize = $this->file_2_validator['maxSize'];
        }
        if($this->file_3_validator) {
            $this->file_3_mimeType = $this->file_3_validator['mimeType'];
            $this->file_3_dimensionW = $this->file_3_validator['dimensionW'];
            $this->file_3_dimensionH = $this->file_3_validator['dimensionH'];
            $this->file_3_maxSize = $this->file_3_validator['maxSize'];
        }
        parent::afterFind(); // TODO: Change the autogenerated stub
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file_1_mimeType', 'file_2_mimeType', 'file_3_mimeType' ,'name_0' ,'name_1','name_2' ,'name_3' ,'name_4'], 'string'],
            [['file_1_dimensionW', 'file_1_dimensionH', 'file_1_maxSize', 'file_2_dimensionW', 'file_2_dimensionH', 'file_2_maxSize', 'file_3_dimensionW', 'file_3_dimensionH', 'file_3_maxSize'], 'integer'],

            [['slug'], 'required'],
            [['text_1', 'text_2', 'text_3', 'text_4', 'text_5', 'text_6', 'text_7', 'file_1', 'file_2', 'file_3', 'use_date', 'use_status'], 'integer'],
            [['file_1_validator', 'file_2_validator', 'file_3_validator'], 'safe'],
            [['slug', 'text_1_label', 'text_2_label', 'text_3_label', 'text_4_label', 'text_5_label', 'text_6_label', 'text_7_label', 'file_1_label', 'file_2_label', 'file_3_label'], 'string', 'max' => 255],
            [['slug'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('cms', 'ID'),
            'slug' => Yii::t('cms', 'Slug'),
            'name_0' => Yii::t('cms', 'Name 0'),
            'name_1' => Yii::t('cms', 'Name 1'),
            'name_2' => Yii::t('cms', 'Name 2'),
            'name_3' => Yii::t('cms', 'Name 3'),
            'name_4' => Yii::t('cms', 'Name 4'),
            'text_1' => Yii::t('cms', 'Text 1'),
            'text_2' => Yii::t('cms', 'Text 2'),
            'text_3' => Yii::t('cms', 'Text 3'),
            'text_4' => Yii::t('cms', 'Text 4'),
            'text_5' => Yii::t('cms', 'Text 5'),
            'text_6' => Yii::t('cms', 'Text 6'),
            'text_7' => Yii::t('cms', 'Text 7'),
            'text_1_label' => Yii::t('cms', 'Text 1 Label'),
            'text_2_label' => Yii::t('cms', 'Text 2 Label'),
            'text_3_label' => Yii::t('cms', 'Text 3 Label'),
            'text_4_label' => Yii::t('cms', 'Text 4 Label'),
            'text_5_label' => Yii::t('cms', 'Text 5 Label'),
            'text_6_label' => Yii::t('cms', 'Text 6 Label'),
            'text_7_label' => Yii::t('cms', 'Text 7 Label'),
            'file_1' => Yii::t('cms', 'File 1'),
            'file_2' => Yii::t('cms', 'File 2'),
            'file_3' => Yii::t('cms', 'File 3'),
            'file_1_label' => Yii::t('cms', 'File 1 Label'),
            'file_2_label' => Yii::t('cms', 'File 2 Label'),
            'file_3_label' => Yii::t('cms', 'File 3 Label'),
            'file_1_maxSize' => Yii::t('cms', 'File 1 max size (mb)'),
            'file_2_maxSize' => Yii::t('cms', 'File 2 max size (mb)'),
            'file_3_maxSize' => Yii::t('cms', 'File 3 max size (mb)'),
            'use_date' => Yii::t('cms', 'Use Date'),
            'use_status' => Yii::t('cms', 'Use Status'),
            'created_at' => Yii::t('cms', 'Created At'),
            'updated_at' => Yii::t('cms', 'Updated At'),
        ];
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
        return $this->hasMany(CaE::class, ['entity_id' => 'id']);
    }

}
