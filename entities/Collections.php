<?php

namespace afzalroq\cms\entities;

use afzalroq\cms\components\FileType;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "cms_collections".
 *
 * @property int         $id
 * @property string|null $name_0
 * @property string|null $name_1
 * @property string|null $name_2
 * @property string|null $name_3
 * @property string|null $name_4
 * @property string      $slug
 * @property int         $use_in_menu
 * @property int|null    $use_parenting
 * @property int|null    $use_seo
 * @property int|null    $option_file_1
 * @property int|null    $option_file_2
 * @property string|null $option_file_1_label
 * @property string|null $option_file_2_label
 * @property array|null  $option_file_1_validator
 * @property array|null  $option_file_2_validator
 * @property int|null    $option_name
 * @property int|null    $option_content
 * @property int|null    $option_default_id
 * @property int         $created_at
 * @property int         $updated_at
 *
 * @property Options     $optionDefault
 * @property Options[]   $options
 */
class Collections extends ActiveRecord
{

	#region OptionAttrs
	const OPTION_NAME_DISABLED = 0;
	const OPTION_NAME_COMMON = 1;
	const OPTION_NAME_TRANSLATABLE = 2;

	const OPTION_CONTENT_DISABLED = 0;
	const OPTION_CONTENT_COMMON_TEXTAREA = 10;
	const OPTION_CONTENT_COMMON_CKEDITOR = 11;
	const OPTION_CONTENT_TRANSLATABLE_TEXTAREA = 20;
	const OPTION_CONTENT_TRANSLATABLE_CKEDITOR = 21;

	const OPTION_FILE_DISABLED = 0;
	const OPTION_FILE_COMMON = 1;
	const OPTION_FILE_TRANSLATABLE = 2;

    #seo types
    const SEO_DISABLED = 0;
    const SEO_COMMON = 1;
    const SEO_TRANSLATABLE = 2;
    #end seo types
	
	#endregion
	#region UseMenu
	const USE_IN_MENU_DISABLED = 0;
	const USE_IN_MENU_OPTIONS = 1;
	const USE_IN_MENU_ITEMS = 2;
	const USE_IN_MENU_OPTIONS_ITEMS = 12;
	#endregion
	#region FileAttrs
	public $file_1_mimeType;
	public $file_1_dimensionW;
	public $file_1_dimensionH;
	public $file_1_maxSize;

	public $file_2_mimeType;
	public $file_2_dimensionW;
	public $file_2_dimensionH;
	public $file_2_maxSize;

	#endregion

	public static function tableName()
	{
		return 'cms_collections';
	}

    #region ListOfConstants

    public static function seoList()
    {
        return [
            self::SEO_DISABLED => Yii::t('cms', 'Disabled'),
            self::SEO_COMMON => Yii::t('cms', 'Common'),
            self::SEO_TRANSLATABLE => Yii::t('cms', 'Translatable'),
        ];
    }

    public static function optionNameList()
    {
        return [
            self::OPTION_NAME_DISABLED => Yii::t('cms', 'Disabled'),
            self::OPTION_NAME_COMMON => Yii::t('cms', 'Common'),
            self::OPTION_NAME_TRANSLATABLE => Yii::t('cms', 'Translatable'),
        ];
    }

    public static function optionContentList()
    {
        return [
            self::OPTION_CONTENT_DISABLED => Yii::t('cms', 'Disabled'),
            self::OPTION_CONTENT_COMMON_TEXTAREA => Yii::t('cms', 'Common textarea'),
            self::OPTION_CONTENT_COMMON_CKEDITOR => Yii::t('cms', 'Common ckeditor'),
            self::OPTION_CONTENT_TRANSLATABLE_TEXTAREA => Yii::t('cms', 'Translatable textarea'),
            self::OPTION_CONTENT_TRANSLATABLE_CKEDITOR => Yii::t('cms', 'Translatable ckeditor'),
        ];
    }

    public static function optionFileList()
    {
        return [
            self::OPTION_FILE_DISABLED => Yii::t('cms', 'Disabled'),
            self::OPTION_FILE_COMMON => Yii::t('cms', 'Common'),
            self::OPTION_FILE_TRANSLATABLE => Yii::t('cms', 'Translatable'),
        ];
    }

    public static function optionUseInMenuList()
    {
        return [
            self::USE_IN_MENU_DISABLED => Yii::t('cms', 'Disabled'),
            self::USE_IN_MENU_OPTIONS => Yii::t('cms', 'Option'),
            self::USE_IN_MENU_ITEMS => Yii::t('cms', 'Item'),
            self::USE_IN_MENU_OPTIONS_ITEMS => Yii::t('cms', 'Options and items'),
        ];
    }

    #endregion


    public function beforeSave($insert)
	{
		$this->option_file_1_validator = [
			'mimeType' => $this->file_1_mimeType !== '' ? $this->file_1_mimeType : null,
			'dimensionW' => $this->file_1_dimensionW ? : null,
			'dimensionH' => $this->file_1_dimensionH ? : null,
			'maxSize' => $this->file_1_maxSize ? : null
		];

		$this->option_file_2_validator = [
			'mimeType' => $this->file_2_mimeType !== '' ? $this->file_2_mimeType : null,
			'dimensionW' => $this->file_2_dimensionW ? : null,
			'dimensionH' => $this->file_2_dimensionH ? : null,
			'maxSize' => $this->file_2_maxSize ? : null
		];

		return parent::beforeSave($insert);
	}

	public function afterFind()
	{
		if($this->option_file_1_validator) {
			$this->file_1_mimeType = $this->option_file_1_validator['mimeType'];
			$this->file_1_dimensionW = $this->option_file_1_validator['dimensionW'];
			$this->file_1_dimensionH = $this->option_file_1_validator['dimensionH'];
			$this->file_1_maxSize = $this->option_file_1_validator['maxSize'];
		}
		if($this->option_file_2_validator) {
			$this->file_2_mimeType = $this->option_file_2_validator['mimeType'];
			$this->file_2_dimensionW = $this->option_file_2_validator['dimensionW'];
			$this->file_2_dimensionH = $this->option_file_2_validator['dimensionH'];
			$this->file_2_maxSize = $this->option_file_2_validator['maxSize'];
		}
		parent::afterFind(); // TODO: Change the autogenerated stub
	}

    public function rules()
    {
        return [
            [['file_1_dimensionW', 'file_1_dimensionH', 'file_2_dimensionW', 'file_2_dimensionH', 'file_1_maxSize', 'file_2_maxSize'], 'integer'],

            [['file_1_mimeType', 'file_2_mimeType'], 'each', 'rule' => ['in', 'range' => array_keys(FileType::MIME_TYPES)]],

            [['slug', 'use_in_menu'], 'required'],
            [['use_in_menu', 'use_parenting', 'option_file_1', 'option_file_2', 'option_name', 'option_content', 'option_default_id', 'created_at', 'updated_at'], 'integer'],
            [['option_file_1_validator', 'option_file_2_validator'], 'safe'],
            [['name_0', 'name_1', 'name_2', 'name_3', 'name_4', 'slug', 'option_file_1_label', 'option_file_2_label'], 'string', 'max' => 255],
            [['slug'], 'unique'],
        ];
    }

	public function behaviors()
	{
		return [
			TimestampBehavior::class,
		];
	}

    public function attributeLabels()
    {
        $language0 = isset(Yii::$app->params['cms']['languages2'][0]) ? Yii::$app->params['cms']['languages2'][0] : '';
        $language1 = isset(Yii::$app->params['cms']['languages2'][1]) ? Yii::$app->params['cms']['languages2'][1] : '';
        $language2 = isset(Yii::$app->params['cms']['languages2'][2]) ? Yii::$app->params['cms']['languages2'][2] : '';
        $language3 = isset(Yii::$app->params['cms']['languages2'][3]) ? Yii::$app->params['cms']['languages2'][3] : '';
        return [
            'id' => Yii::t('cms', 'ID'),
            'name_0' => Yii::t('cms', 'Name') . '(' . $language0 . ')',
            'name_1' => Yii::t('cms', 'Name') . '(' . $language1 . ')',
            'name_2' => Yii::t('cms', 'Name') . '(' . $language2 . ')',
            'name_3' => Yii::t('cms', 'Name') . '(' . $language3 . ')',
            'name_4' => Yii::t('cms', 'Name') . '(' . $language3 . ')',
            'slug' => Yii::t('cms', 'Slug'),
            'use_in_menu' => Yii::t('cms', 'Use in menu'),
            'use_parenting' => Yii::t('cms', 'Use parenting'),

            'option_file_1' => Yii::t('cms', 'Option File') . ' 1',
            'option_file_2' => Yii::t('cms', 'Option File') . ' 2',
            'option_file_1_label' => Yii::t('cms', 'Option File') . ' 1 ' . Yii::t('cms', 'Label'),
            'option_file_2_label' => Yii::t('cms', 'Option File') . ' 2 ' . Yii::t('cms', 'Label'),
            'option_file_1_validator' => Yii::t('cms', 'Option File') . ' 1 ' . Yii::t('cms', 'Validator'),
            'option_file_2_validator' => Yii::t('cms', 'Option File') . ' 2 ' . Yii::t('cms', 'Validator'),

            'option_name' => Yii::t('cms', 'Option') . ' ' . Yii::t('cms', 'Name'),
            'option_content' => Yii::t('cms', 'Option') . ' ' . Yii::t('cms', 'Content'),
            'option_default_id' => Yii::t('cms', 'Default option'),
            'created_at' => Yii::t('cms', 'Created At'),
            'updated_at' => Yii::t('cms', 'Updated At'),

            'file_1_mimeType' => Yii::t('cms', 'File') . ' 1 ' . Yii::t('cms', 'Extension'),
            'file_1_dimensionW' => Yii::t('cms', 'File') . ' 1 ' . Yii::t('cms', 'Width'),
            'file_1_dimensionH' => Yii::t('cms', 'File') . ' 1 ' . Yii::t('cms', 'Height'),
            'file_1_maxSize' => Yii::t('cms', 'File') . ' 1 ' . Yii::t('cms', 'Max size'),

            'file_2_mimeType' => Yii::t('cms', 'File') . ' 2 ' . Yii::t('cms', 'Extension'),
            'file_2_dimensionW' => Yii::t('cms', 'File') . ' 2 ' . Yii::t('cms', 'Width'),
            'file_2_dimensionH' => Yii::t('cms', 'File') . ' 2 ' . Yii::t('cms', 'Height'),
            'file_2_maxSize' => Yii::t('cms', 'File') . ' 2 ' . Yii::t('cms', 'Max size'),
        ];
    }

    public function nameAttrs()
    {
        $nameAttrs = [];
        foreach(Yii::$app->params['cms']['languages2'] as $key => $language) {
            $nameAttrs[] =  'name_' . $key;
        }

        return $nameAttrs;
    }


    /**
	 * Gets query for [[OptionDefault]].
	 *
	 * @return ActiveQuery
	 */
	public function getOptionDefault()
	{
		return $this->hasOne(Options::class, ['id' => 'option_default_id']);
	}

	/**
	 * Gets query for [[Options]].
	 *
	 * @return ActiveQuery
	 */
	public function getOptions()
	{
		return $this->hasMany(Options::class, ['collection_id' => 'id']);
	}

}
