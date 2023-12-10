<?php

namespace afzalroq\cms\entities;

use afzalroq\cms\components\FileType;
use afzalroq\cms\interfaces\Linkable;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Exception;
use yii\helpers\StringHelper;

/**
 * This is the model class for table "cms_collections".
 *
 * @property int $id
 * @property string|null $name_0
 * @property string|null $name_1
 * @property string|null $name_2
 * @property string|null $name_3
 * @property string|null $name_4
 * @property string $slug
 * @property int $use_in_menu
 * @property int|null $use_parenting
 * @property int|null $use_seo
 * @property int|null $option_file_1
 * @property int|null $option_file_2
 * @property string|null $option_file_1_label
 * @property string|null $option_file_2_label
 * @property array|null $option_file_1_validator
 * @property array|null $option_file_2_validator
 * @property int|null $option_name
 * @property int|null $option_content
 * @property int|null $option_default_id
 * @property int $created_at
 * @property int $updated_at
 * @property int|null $manual_slug
 *
 * @property Options $optionDefault
 * @property Options[] $options
 */
class Collections extends ActiveRecord implements Linkable
{
    #region Constants

    const DISABLED = -1;

    #region OptionAttrs

    // Option name
    const OPTION_NAME_DISABLED = 0;

    const OPTION_NAME_COMMON = 1;

    const OPTION_NAME_TRANSLATABLE = 2;

    // Option content
    const OPTION_CONTENT_DISABLED = 0;

    const OPTION_CONTENT_COMMON_TEXTAREA = 10;

    const OPTION_CONTENT_COMMON_CKEDITOR = 11;

    const OPTION_CONTENT_TRANSLATABLE_TEXTAREA = 20;

    const OPTION_CONTENT_TRANSLATABLE_CKEDITOR = 21;

    // Option file
    const OPTION_FILE_DISABLED = 0;

    const OPTION_FILE_COMMON = 1;

    const OPTION_FILE_TRANSLATABLE = 2;

    // Option text
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


    #region seo types

    const SEO_DISABLED = 0;

    const SEO_COMMON = 1;

    const SEO_TRANSLATABLE = 2;

    #endregion

    #region UseMenu

    const USE_IN_MENU_DISABLED = 0;

    const USE_IN_MENU_OPTIONS = 1;

    const USE_IN_MENU_ITEMS = 2;

    const USE_IN_MENU_OPTIONS_ITEMS = 12;

    #endregion

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

    private $cpId;

    #endregion

    #region Override methods

    public static function tableName()
    {
        return 'cms_collections';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function beforeSave($insert)
    {
        $this->option_file_1_validator = [
            'mimeType'   => $this->file_1_mimeType !== '' ? $this->file_1_mimeType : null,
            'dimensionW' => $this->file_1_dimensionW ?: null,
            'dimensionH' => $this->file_1_dimensionH ?: null,
            'maxSize'    => $this->file_1_maxSize ?: null,
        ];

        $this->option_file_2_validator = [
            'mimeType'   => $this->file_2_mimeType !== '' ? $this->file_2_mimeType : null,
            'dimensionW' => $this->file_2_dimensionW ?: null,
            'dimensionH' => $this->file_2_dimensionH ?: null,
            'maxSize'    => $this->file_2_maxSize ?: null,
        ];

        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        if ($this->option_file_1_validator) {
            $this->file_1_mimeType   = isset($this->option_file_1_validator['mimeType']) ? $this->option_file_1_validator['mimeType'] : "";
            $this->file_1_dimensionW = isset($this->option_file_1_validator['dimensionW']) ? $this->option_file_1_validator['dimensionW'] : "";
            $this->file_1_dimensionH = isset($this->option_file_1_validator['dimensionH']) ? $this->option_file_1_validator['dimensionH'] : "";
            $this->file_1_maxSize    = isset($this->option_file_1_validator['maxSize']) ? $this->option_file_1_validator['maxSize'] : "";
        }
        if ($this->option_file_2_validator) {
            $this->file_2_mimeType   = isset($this->option_file_2_validator['mimeType']) ? $this->option_file_2_validator['mimeType'] : "";
            $this->file_2_dimensionW = isset($this->option_file_2_validator['dimensionW']) ? $this->option_file_2_validator['dimensionW'] : "";
            $this->file_2_dimensionH = isset($this->option_file_2_validator['dimensionH']) ? $this->option_file_2_validator['dimensionH'] : "";
            $this->file_2_maxSize    = isset($this->option_file_2_validator['maxSize']) ? $this->option_file_2_validator['maxSize'] : "";
        }
        parent::afterFind(); // TODO: Change the autogenerated stub
    }

    public function isTranslatebleNameOrContent($field)
    {
        return in_array($this->{$field}, [
            self::OPTION_NAME_TRANSLATABLE,
            self::OPTION_CONTENT_TRANSLATABLE_CKEDITOR,
            self::OPTION_CONTENT_TRANSLATABLE_TEXTAREA,
        ]);
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
            self::TEXT_TRANSLATABLE_CKEDITOR,
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
            self::TEXT_COMMON_CKEDITOR,
        ];
    }

    public function isCommonText($field)
    {
        return in_array($this->{$field}, $this->commonTextTypes());
    }


    public function isHaveHtmltags($field)
    {
        return $this->{$field} == self::TEXT_TRANSLATABLE_CKEDITOR;
    }

    public function beforeDelete()
    {
        $this->cpId = $this->id;
        if (!parent::beforeDelete()) {
            return false;
        }

        CaE::deleteAll(['collection_id' => $this->id]);

        foreach (Options::findAll(['collection_id' => $this->id]) as $option) {
            OaI::deleteAll(['option_id' => $option->id]);
            if (!$option->deleteWithChildren()) {
                throw new Exception("Cannot delete of id: {$option->id} option");
            }
        }

        return true;
    }

    public function afterDelete()
    {
        parent::afterDelete();

        foreach (Menu::find()->all() as $menu) {
            if ($menu->type !== Menu::TYPE_COLLECTION) {
                continue;
            }
            if ($menu->type_helper != $this->cpId) {
                continue;
            }

            if (!$menu->delete()) {
                throw new Exception("Cannot delete id: {$menu->id} of menu");
            }
        }
    }

    public function rules()
    {
        return [
            [
                [
                    'file_1_dimensionW',
                    'file_1_dimensionH',
                    'file_2_dimensionW',
                    'file_2_dimensionH',
                    'file_1_maxSize',
                    'file_2_maxSize',
                ],
                'integer',
            ],

            [
                ['file_1_mimeType', 'file_2_mimeType'],
                'each',
                'rule' => ['in', 'range' => array_keys(FileType::MIME_TYPES)],
            ],
            [['file_1_mimeType', 'file_2_mimeType'], 'checkMimeType'],

            [['slug', 'use_in_menu', 'use_seo'], 'required'],

            [
                [
                    'use_in_menu',
                    'use_seo',
                    'use_parenting',
                    'manual_slug',
                    'option_file_1',
                    'option_file_2',
                    'option_name',
                    'option_content',
                    'option_default_id',
                    'created_at',
                    'updated_at',
                ],
                'integer',
            ],


            [['option_file_1_validator', 'option_file_2_validator'], 'safe'],

            [
                [
                    'name_0',
                    'name_1',
                    'name_2',
                    'name_3',
                    'name_4',
                    'slug',
                    'option_file_1_label',
                    'option_file_2_label',
                ],
                'string',
                'max' => 255,
            ],

            [['slug'], 'unique'],
            [['slug'], 'afzalroq\cms\validators\SlugValidator'],

            [['text_1', 'text_2', 'text_3', 'text_4'], 'integer'],

            [['text_1_label', 'text_2_label', 'text_3_label', 'text_4_label'], 'string', 'max' => 255],


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
            'id'            => Yii::t('cms', 'ID'),
            'name_0'        => Yii::t('cms', 'Name') . '(' . $language0 . ')',
            'name_1'        => Yii::t('cms', 'Name') . '(' . $language1 . ')',
            'name_2'        => Yii::t('cms', 'Name') . '(' . $language2 . ')',
            'name_3'        => Yii::t('cms', 'Name') . '(' . $language3 . ')',
            'name_4'        => Yii::t('cms', 'Name') . '(' . $language4 . ')',
            'slug'          => Yii::t('cms', 'Slug'),
            'use_in_menu'   => Yii::t('cms', 'Use in menu'),
            'use_parenting' => Yii::t('cms', 'Use parenting'),
            'use_seo'       => Yii::t('cms', 'Use SEO'),
            'manual_slug'   => Yii::t('cms', 'Manual slug'),

            'option_file_1'           => Yii::t('cms', 'Option File') . ' 1',
            'option_file_2'           => Yii::t('cms', 'Option File') . ' 2',
            'option_file_1_label'     => Yii::t('cms', 'Option File') . ' 1 ' . Yii::t('cms', 'Label'),
            'option_file_2_label'     => Yii::t('cms', 'Option File') . ' 2 ' . Yii::t('cms', 'Label'),
            'option_file_1_validator' => Yii::t('cms', 'Option File') . ' 1 ' . Yii::t('cms', 'Validator'),
            'option_file_2_validator' => Yii::t('cms', 'Option File') . ' 2 ' . Yii::t('cms', 'Validator'),

            'option_name'       => Yii::t('cms', 'Option') . ' ' . Yii::t('cms', 'Name'),
            'option_content'    => Yii::t('cms', 'Option') . ' ' . Yii::t('cms', 'Content'),
            'option_default_id' => Yii::t('cms', 'Default option'),
            'created_at'        => Yii::t('cms', 'Created At'),
            'updated_at'        => Yii::t('cms', 'Updated At'),

            'file_1_mimeType'   => Yii::t('cms', 'File') . ' 1 ' . Yii::t('cms', 'Extension'),
            'file_1_dimensionW' => Yii::t('cms', 'File') . ' 1 ' . Yii::t('cms', 'Width'),
            'file_1_dimensionH' => Yii::t('cms', 'File') . ' 1 ' . Yii::t('cms', 'Height'),
            'file_1_maxSize'    => Yii::t('cms', 'File') . ' 1 ' . Yii::t('cms', 'Max size'),

            'file_2_mimeType'   => Yii::t('cms', 'File') . ' 2 ' . Yii::t('cms', 'Extension'),
            'file_2_dimensionW' => Yii::t('cms', 'File') . ' 2 ' . Yii::t('cms', 'Width'),
            'file_2_dimensionH' => Yii::t('cms', 'File') . ' 2 ' . Yii::t('cms', 'Height'),
            'file_2_maxSize'    => Yii::t('cms', 'File') . ' 2 ' . Yii::t('cms', 'Max size'),

            'text_1'       => Yii::t('cms', 'Text 1'),
            'text_2'       => Yii::t('cms', 'Text 2'),
            'text_3'       => Yii::t('cms', 'Text 3'),
            'text_4'       => Yii::t('cms', 'Text 4'),
            'text_1_label' => Yii::t('cms', 'Text 1 label'),
            'text_2_label' => Yii::t('cms', 'Text 2 label'),
            'text_3_label' => Yii::t('cms', 'Text 3 label'),
            'text_4_label' => Yii::t('cms', 'Text 4 label'),
        ];
    }

    #endregion

    #region Extra methods

    public function checkMimeType($attribute, $params)
    {
        if (($attribute == 'file_1_mimeType') && !empty($this->file_1_mimeType) && (count($this->file_1_mimeType) > 1 && in_array(2,
                    $this->file_1_mimeType))) {
            $this->addError($attribute,
                $attribute . ' ' . Yii::t('cms', 'If the SVG format is used in the file, no other format can be used'));
        }
        if (($attribute == 'file_2_mimeType') && !empty($this->file_2_mimeType) && (count($this->file_2_mimeType) > 1 && in_array(2,
                    $this->file_2_mimeType))) {
            $this->addError($attribute,
                $attribute . ' ' . Yii::t('cms', 'If the SVG format is used in the file, no other format can be used'));
        }
    }

    public function add()
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $this->save();

            if (!$this->addRootOption()) {
                $transaction->rollBack();
            }

            $transaction->commit();

            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    private function addRootOption()
    {
        $option                   = new Options();
        $option->collection_id    = $this->id;
        $option->parentCollection = $this;
        $option->tree             = Options::find()->max('tree') + 1;
        $name                     = 'name_' . array_key_first(Yii::$app->params['cms']['languages']);
        $option->$name            = StringHelper::mb_ucfirst($this->slug) . ' option';
        $option->slug             = StringHelper::mb_ucfirst($this->slug) . '_option';

        return $option->makeRoot(false);
    }

    #region ListOfConstants

    public static function seoList()
    {
        return [
            self::SEO_DISABLED     => Yii::t('cms', 'Disabled'),
            self::SEO_COMMON       => Yii::t('cms', 'Common'),
            self::SEO_TRANSLATABLE => Yii::t('cms', 'Translatable'),
        ];
    }

    public static function optionNameList()
    {
        return [
            self::OPTION_NAME_DISABLED     => Yii::t('cms', 'Disabled'),
            self::OPTION_NAME_COMMON       => Yii::t('cms', 'Common'),
            self::OPTION_NAME_TRANSLATABLE => Yii::t('cms', 'Translatable'),
        ];
    }

    public static function optionContentList()
    {
        return [
            self::OPTION_CONTENT_DISABLED              => Yii::t('cms', 'Disabled'),
            self::OPTION_CONTENT_COMMON_TEXTAREA       => Yii::t('cms', 'Common textarea'),
            self::OPTION_CONTENT_COMMON_CKEDITOR       => Yii::t('cms', 'Common ckeditor'),
            self::OPTION_CONTENT_TRANSLATABLE_TEXTAREA => Yii::t('cms', 'Translatable textarea'),
            self::OPTION_CONTENT_TRANSLATABLE_CKEDITOR => Yii::t('cms', 'Translatable ckeditor'),
        ];
    }

    public static function optionFileList()
    {
        return [
            self::OPTION_FILE_DISABLED     => Yii::t('cms', 'Disabled'),
            self::OPTION_FILE_COMMON       => Yii::t('cms', 'Common'),
            self::OPTION_FILE_TRANSLATABLE => Yii::t('cms', 'Translatable'),
        ];
    }

    public static function optionUseInMenuList()
    {
        return [
            self::USE_IN_MENU_DISABLED      => Yii::t('cms', 'Disabled'),
            self::USE_IN_MENU_OPTIONS       => Yii::t('cms', 'Options'),
//            self::USE_IN_MENU_ITEMS => Yii::t('cms', 'Item'),
            self::USE_IN_MENU_OPTIONS_ITEMS => Yii::t('cms', 'Options and items'),
        ];
    }

    #endregion

    private function getFileMaxSize($number)
    {
        if ($this['file_' . $number . '_maxSize']) {
            return $this['file_' . $number . '_maxSize'] . ' MB';
        }

        return null;
    }

    private function getFileMimeType($number)
    {
        if ($this['file_' . $number . '_mimeType']) {
            return FileType::fileMimeTypes($this['file_' . $number . '_mimeType']);
        }

        return null;
    }

    public function nameAttrs()
    {
        $nameAttrs = [];
        foreach (Yii::$app->params['cms']['languages'] as $key => $language) {
            $nameAttrs[] = 'name_' . $key;
        }

        return
            $nameAttrs;
    }

    public function textAttrs()
    {
        $collectionTextAttrs = [];
        foreach ($this->attributes as $attr => $value) {
            if (preg_match('/^text_[1-7]$/', $attr)) {
                $collectionTextAttrs[$attr] = $value;
            }
        }

        return $collectionTextAttrs;
    }

    public function getName($key = null)
    {
        $key = isset($key) ? $key : \Yii::$app->language;

        if (is_string($key)) {
            $key = \Yii::$app->params['cms']['languageIds'][$key];
        }

        return $this['name_' . $key];
    }

    public function getOptionDefault()
    {
        return $this->hasOne(Options::class, ['id' => 'option_default_id']);
    }

    public function getOptions()
    {
        return $this->hasMany(Options::class, ['collection_id' => 'id']);
    }

    #region Aliases

    public function getFile1MaxSize()
    {
        return $this->getFileMaxSize('1');
    }

    public function getFile2MaxSize()
    {
        return $this->getFileMaxSize('2');
    }

    public function getFile1MimeType()
    {
        return $this->getFileMimeType('1');
    }

    public function getFile2MimeType()
    {
        return $this->getFileMimeType('2');
    }

    #endregion

    #endregion

    public function getLink(): string
    {
        return '/c/' . $this->slug;
    }
}
