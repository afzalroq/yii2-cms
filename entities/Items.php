<?php

namespace afzalroq\cms\entities;

use afzalroq\cms\components\FileType;
use afzalroq\cms\components\Image;
use afzalroq\cms\entities\front\Options;
use afzalroq\cms\helpers\TextConverter;
use afzalroq\cms\interfaces\Linkable;
use afzalroq\cms\Module;
use DomainException;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\caching\TagDependency;
use yii\db\ActiveRecord;
use yii\db\Exception;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;


/**
 * This is the model class for table "cms_items".
 *
 * @property int $id
 * @property int $entity_id
 * @property string $slug
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
 * @property string|null $text_5_0
 * @property string|null $text_5_1
 * @property string|null $text_5_2
 * @property string|null $text_5_3
 * @property string|null $text_5_4
 * @property string|null $text_6_0
 * @property string|null $text_6_1
 * @property string|null $text_6_2
 * @property string|null $text_6_3
 * @property string|null $text_6_4
 * @property string|null $text_7_0
 * @property string|null $text_7_1
 * @property string|null $text_7_2
 * @property string|null $text_7_3
 * @property string|null $text_7_4
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
 * @property string|null $file_3_0
 * @property string|null $file_3_1
 * @property string|null $file_3_2
 * @property string|null $file_3_3
 * @property string|null $file_3_4
 * @property string|null $seo_values
 * @property int|null $date_0
 * @property int|null $date_1
 * @property int|null $date_2
 * @property int|null $date_3
 * @property int|null $date_4
 * @property int|null $status
 * @property int|null $comments_count
 * @property int|null $votes_count
 * @property int|null $avarage_voting
 * @property int $created_at
 * @property int $updated_at
 * @property ItemPhotos[] $photos
 * @property Entities $entity
 */
class Items extends ActiveRecord implements Linkable
{
    const STATUS_DRAFT = 0;

    const STATUS_ACTIVE = 1;

    #region Extra Attributes

    /**
     * @var mixed|null
     */
    public $options;

    public $o;

    public $files;

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

    public $dependEntity;

    public $languageId;

    private $cpId;

    #endregion

    #region Overwrite Methods

    public function __construct($slug = null, $config = [])
    {
        if ($slug) {
            $this->dependEntity = Entities::findOne(['slug' => $slug]);
            if ($this->dependEntity->manual_slug) {
                $this->detachBehavior('slug');
            }
        } else {
            $this->dependEntity = $this->entity;
        }
        $this->setCurrentLanguage();

        parent::__construct($config);
    }

    private function setCurrentLanguage()
    {
        $this->languageId = Yii::$app->params['l'][Yii::$app->language];
        if (!$this->languageId) {
            $this->languageId = 0;
        }
    }

    public static function tableName()
    {
        return 'cms_items';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class,
            'slug' => [
                'class'                => 'Zelenin\yii\behaviors\Slug',
                'slugAttribute'        => 'slug',
                'attribute'            => 'text_1_' . array_key_first(Yii::$app->params['cms']['languages']),
                'ensureUnique'         => true,
                'replacement'          => '-',
                'lowercase'            => true,
                'immutable'            => false,
                'transliterateOptions' => 'uz_Cyrl-uz_Latn; Russian-Latin/BGN; Any-Latin; Latin-ASCII; NFD; [:Nonspacing Mark:] Remove; NFC;',
            ],
            $this->getImageUploadBehaviorConfig('file_1_0'),
            $this->getImageUploadBehaviorConfig('file_1_1'),
            $this->getImageUploadBehaviorConfig('file_1_2'),
            $this->getImageUploadBehaviorConfig('file_1_3'),
            $this->getImageUploadBehaviorConfig('file_1_4'),
            $this->getImageUploadBehaviorConfig('file_2_0'),
            $this->getImageUploadBehaviorConfig('file_2_1'),
            $this->getImageUploadBehaviorConfig('file_2_2'),
            $this->getImageUploadBehaviorConfig('file_2_3'),
            $this->getImageUploadBehaviorConfig('file_2_4'),
            $this->getImageUploadBehaviorConfig('file_3_0'),
            $this->getImageUploadBehaviorConfig('file_3_1'),
            $this->getImageUploadBehaviorConfig('file_3_2'),
            $this->getImageUploadBehaviorConfig('file_3_3'),
            $this->getImageUploadBehaviorConfig('file_3_4'),

        ];
    }

    private function getImageUploadBehaviorConfig($attribute)
    {
        $module = Yii::$app->getModule('cms');

        return [
            'class'     => ImageUploadBehavior::class,
            'attribute' => $attribute,
            'filePath'  => $module->path . '/data/items/[[attribute_id]]/[[filename]].[[extension]]',
            'fileUrl'   => $module->host . '/data/items/[[attribute_id]]/[[filename]].[[extension]]',
        ];
    }

    public function beforeValidate(): bool
    {
        if (parent::beforeValidate()) {
            $this->files = UploadedFile::getInstances($this, 'files');

            return true;
        }

        return false;
    }

    public function getLink(): string
    {
        return '/e/' . $this->entity->slug . '/' . $this->id . '-' . $this->slug;
    }

    public function beforeSave($insert)
    {
        $this->slug = preg_replace('/[^a-z0-9\-]/', '', $this->slug);

        if ($this->entity->use_seo) {
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
                'meta_keyword_4' => $this->meta_keyword_4 ?? null,
            ];
        }

        $entity = Entities::findOne($this->entity_id);

        if ($insert && $entity->use_status != null) {
            $this->status = self::STATUS_DRAFT;
        }
        if (Module::getInstance()->textConverter) {
            $uz = \Yii::$app->params['cms']['languageIds']['uz'] ?? null;
            $oz = \Yii::$app->params['cms']['languageIds']['oz'] ?? null;
            if ($oz && $uz) {
                $attrs  = [
                    'text_1',
                    'text_2',
                    'text_3',
                    'text_4',
                    'text_5',
                    'text_6',
                    'text_7',
                ];
                $entity = $this->entity;

                foreach ($attrs as $attr) {
                    if ($entity->isTranslateble($attr)) {
                        $attrUz = $this->{$attr . '_' . $uz};
                        $attrOz = $this->{$attr . '_' . $oz};
                        if (empty($attrUz) && !empty($attrOz)) {
                            $attrUz = TextConverter::convertText($attrOz, true);
                        } elseif (empty($attrOz) && !empty($attrUz)) {
                            $attrOz = TextConverter::convertText($attrUz, false);
                        }
//                        if ($entity->isHaveHtmltags($attr)) {
//                            if (empty($attrUz) && !empty($attrOz)) {
//                                $attrUz = TextConverter::convert($attrOz, 'to_latin');
//                            } elseif (empty($attrOz) && !empty($attrUz)) {
//                                $attrOz = TextConverter::convert($attrUz, 'to_cyrillic');
//                            }
//                        } else {
//                            if (empty($attrUz) && !empty($attrOz)) {
//                                $attrUz = TextConverter::to_latin($attrOz);
//                            } elseif (empty($attrOz) && !empty($attrUz)) {
//                                $attrOz = TextConverter::to_cyrillic($attrUz);
//                            }
//                        }
                    }
                }
            }

        }

        return parent::beforeSave($insert);
    }


    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        TagDependency::invalidate(Yii::$app->{Yii::$app->getModule('cms')->cache}, 'items_' . $this->entity->slug);

        OaI::deleteAll(['item_id' => $this->id]);

        if ($this->options) {
            foreach ($this->options as $collectionSlug => $optionIds) {
                if (is_array($optionIds)) {
                    foreach ($optionIds as $optionId) {
                        $model            = new OaI();
                        $model->option_id = $optionId;
                        $model->item_id   = $this->id;
                        $model->save();
                    }
                } else {
                    $model            = new OaI();
                    $model->option_id = $optionIds;
                    $model->item_id   = $this->id;
                    $model->save();
                }
            }
        }

        return true;
    }

    public function afterFind()
    {
        parent::afterFind();

        if ($this->entity->manual_slug) {
            $this->detachBehavior('slug');
        }

        if (Yii::$app->getModule('cms')->optimized) {
            $options     = Options::findAll(OaI::find()->select('option_id')->where(['item_id' => $this->id])->column());
            $collections = Collections::findAll(CaE::find()->select('collection_id')->where(['entity_id' => $this->entity_id])->column());

            foreach ($collections as $collection) {
                $this->o[$collection->slug] = [];
            }

            foreach ($collections as $collection) {
                foreach ($options as $option) {
                    if ($option->collection_id == $collection->id) {
                        $this->o[$collection->slug][] = $option;
                    }
                }
                if (!count($this->o[$collection->slug])) {
                    $this->o[$collection->slug][] = null;
                }
            }
        }
//        else {
        foreach (OaI::findAll(['item_id' => $this->id]) as $oai)
            foreach ($this->entity->caes as $cae)
                foreach ($cae->collection->options as $option)
                    if ($option->id === $oai->option_id)
                        switch ($cae->type) {
                            case CaE::TYPE_CHECKBOX:
                                $this->options[$cae->collection->slug][] = $oai->option_id;
                                break;
                            case CaE::TYPE_SELECT:
                            case CaE::TYPE_RADIO:
                                $this->options[$cae->collection->slug] = $oai->option_id;
                                break;
                        }
//        }

        if ($this->entity->use_seo) {
            $this->meta_title_0 = isset($this->seo_values['meta_title_0']) ? $this->seo_values['meta_title_0'] : "";
            $this->meta_title_1 = isset($this->seo_values['meta_title_1']) ? $this->seo_values['meta_title_1'] : "";
            $this->meta_title_2 = isset($this->seo_values['meta_title_2']) ? $this->seo_values['meta_title_2'] : "";
            $this->meta_title_3 = isset($this->seo_values['meta_title_3']) ? $this->seo_values['meta_title_3'] : "";
            $this->meta_title_4 = isset($this->seo_values['meta_title_4']) ? $this->seo_values['meta_title_4'] : "";

            $this->meta_des_0 = isset($this->seo_values['meta_des_0']) ? $this->seo_values['meta_des_0'] : "";
            $this->meta_des_1 = isset($this->seo_values['meta_des_1']) ? $this->seo_values['meta_des_1'] : "";
            $this->meta_des_2 = isset($this->seo_values['meta_des_2']) ? $this->seo_values['meta_des_2'] : "";
            $this->meta_des_3 = isset($this->seo_values['meta_des_3']) ? $this->seo_values['meta_des_3'] : "";
            $this->meta_des_4 = isset($this->seo_values['meta_des_4']) ? $this->seo_values['meta_des_4'] : "";

            $this->meta_keyword_0 = isset($this->seo_values['meta_keyword_0']) ? $this->seo_values['meta_keyword_0'] : "";
            $this->meta_keyword_1 = isset($this->seo_values['meta_keyword_1']) ? $this->seo_values['meta_keyword_1'] : "";
            $this->meta_keyword_2 = isset($this->seo_values['meta_keyword_2']) ? $this->seo_values['meta_keyword_2'] : "";
            $this->meta_keyword_3 = isset($this->seo_values['meta_keyword_3']) ? $this->seo_values['meta_keyword_3'] : "";
            $this->meta_keyword_4 = isset($this->seo_values['meta_keyword_4']) ? $this->seo_values['meta_keyword_4'] : "";
        }
    }


    public function afterDelete()
    {
        parent::afterDelete();

        TagDependency::invalidate(Yii::$app->{Yii::$app->getModule('cms')->cache}, 'items_' . $this->entity->slug);

        foreach (Menu::find()->all() as $menu) {
            $shouldDelete = false;
            if ($menu->type === Menu::TYPE_ENTITY_ITEM && $menu->type_helper == $this->cpId) {
                $shouldDelete = true;
            }
            if ($menu->type === Menu::TYPE_ITEM && explode(',', $menu->type_helper)[1] == $this->cpId) {
                $shouldDelete = true;
            }
            if ($shouldDelete && !$menu->delete()) {
                throw new Exception("Cannot delete id: {$menu->id} of menu");
            }
        }
    }

    #endregion

    #region Extra Methods

    public function rules()
    {
        if (empty($this->dependEntity)) {
            $this->dependEntity = $this->entity;
        }

        return [
            $this->fileValidator('file_1'),
            $this->fileValidator('file_2'),
            $this->fileValidator('file_3'),

            $this->requiredValidator('text_1'),
            $this->requiredValidator('text_2'),
            $this->requiredValidator('text_3'),
            $this->requiredValidator('text_4'),
            $this->requiredValidator('text_5'),
            $this->requiredValidator('text_6'),
            $this->requiredValidator('text_7'),

            ['options', 'safe'],

            [['entity_id'], 'required'],
            [['entity_id', 'date_0', 'date_1', 'date_2', 'date_3', 'date_4', 'status'], 'integer'],
            [['date_0', 'date_1', 'date_2', 'date_3', 'date_4'], 'default', 'value' => time()],

            [
                [
                    'text_1_0',
                    'text_1_1',
                    'text_1_2',
                    'text_1_3',
                    'text_1_4',
                    'text_2_0',
                    'text_2_1',
                    'text_2_2',
                    'text_2_3',
                    'text_2_4',
                    'text_3_0',
                    'text_3_1',
                    'text_3_2',
                    'text_3_3',
                    'text_3_4',
                    'text_4_0',
                    'text_4_1',
                    'text_4_2',
                    'text_4_3',
                    'text_4_4',
                    'text_5_0',
                    'text_5_1',
                    'text_5_2',
                    'text_5_3',
                    'text_5_4',
                    'text_6_0',
                    'text_6_1',
                    'text_6_2',
                    'text_6_3',
                    'text_6_4',
                    'text_7_0',
                    'text_7_1',
                    'text_7_2',
                    'text_7_3',
                    'text_7_4',
                    'meta_title_0',
                    'meta_des_0',
                    'meta_keyword_0',
                    'meta_title_1',
                    'meta_keyword_1',
                    'meta_des_1',
                    'meta_title_2',
                    'meta_des_2',
                    'meta_keyword_2',
                    'meta_title_3',
                    'meta_des_3',
                    'meta_keyword_3',
                    'meta_title_4',
                    'meta_des_4',
                    'meta_keyword_4',
                ],
                'string',
            ],

            ['slug', 'string', 'max' => 255],
            [['slug'], 'unique'],
            [
                ['slug'],
                'afzalroq\cms\validators\SlugValidator',
                'when' => function ($model) {
                    return $model->dependEntity->manual_slug;
                },
            ],

            [
                ['entity_id'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => Entities::class,
                'targetAttribute' => ['entity_id' => 'id'],
            ],

            ['files', 'each', 'rule' => ['image']],

            [
                ['main_photo_id'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => ItemPhotos::class,
                'targetAttribute' => ['main_photo_id' => 'id'],
            ],

            // comment section uchun qo'shilgan maydonlar
            [['comments_count', 'votes_count'], 'integer'],
            [['comments_count', 'votes_count'], 'default', 'value' => 0],
            [['avarage_voting'], 'number'],
            [['avarage_voting'], 'default', 'value' => 0.0],
        ];
    }

    public function fileValidator($entityAttr)
    {
        $maxSize = ($this->dependEntity[$entityAttr . '_maxSize'] ?: 0) * 1024 * 1024;

        return [
            $this->getCurrentAttrs($entityAttr),
            'file',
            'extensions'               => FileType::fileExtensions($this->dependEntity[$entityAttr . '_mimeType']),
            'checkExtensionByMimeType' => false,
            'maxSize'                  => ($maxSize) ? $maxSize : null,
        ];
    }

    public function getCurrentAttrs($entityAttr)
    {
        if ($this->isAttrCommon($entityAttr)) {
            return [$entityAttr . '_0'];
        }

        $attrs = [];
        foreach (Yii::$app->params['cms']['languages'] as $key => $language) {
            $attrs[] = $entityAttr . '_' . $key;
        }

        return $attrs;
    }

    public function getOptionsName()
    {
        return $this->hasMany(Options::className(), ['id' => 'option_id'])->viaTable('{{%cms_options_and_items}}',
            ['item_id' => 'id']);
    }

    public function requiredValidator($entityAttr)
    {
        return [
            $this->getCurrentAttrs($entityAttr),
            'required',
            'when'                   => function ($model) use ($entityAttr) {
                return $model->requireValidator($model->dependEntity->{$entityAttr});
            },
            'enableClientValidation' => false,
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
            'id'             => Yii::t('cms', 'ID'),
            'entity_id'      => Yii::t('cms', 'Entity ID'),
            'slug'           => Yii::t('cms', 'Slug'),
            'text_1_0'       => Yii::t('cms', 'Text 1') . '(' . $language0 . ')',
            'text_1_1'       => Yii::t('cms', 'Text 1') . '(' . $language1 . ')',
            'text_1_2'       => Yii::t('cms', 'Text 1') . '(' . $language2 . ')',
            'text_1_3'       => Yii::t('cms', 'Text 1') . '(' . $language3 . ')',
            'text_1_4'       => Yii::t('cms', 'Text 1') . '(' . $language4 . ')',
            'text_2_0'       => Yii::t('cms', 'Text 2') . '(' . $language0 . ')',
            'text_2_1'       => Yii::t('cms', 'Text 2') . '(' . $language1 . ')',
            'text_2_2'       => Yii::t('cms', 'Text 2') . '(' . $language2 . ')',
            'text_2_3'       => Yii::t('cms', 'Text 2') . '(' . $language3 . ')',
            'text_2_4'       => Yii::t('cms', 'Text 2') . '(' . $language4 . ')',
            'text_3_0'       => Yii::t('cms', 'Text 3') . '(' . $language0 . ')',
            'text_3_1'       => Yii::t('cms', 'Text 3') . '(' . $language1 . ')',
            'text_3_2'       => Yii::t('cms', 'Text 3') . '(' . $language2 . ')',
            'text_3_3'       => Yii::t('cms', 'Text 3') . '(' . $language3 . ')',
            'text_3_4'       => Yii::t('cms', 'Text 3') . '(' . $language4 . ')',
            'text_4_0'       => Yii::t('cms', 'Text 4') . '(' . $language0 . ')',
            'text_4_1'       => Yii::t('cms', 'Text 4') . '(' . $language1 . ')',
            'text_4_2'       => Yii::t('cms', 'Text 4') . '(' . $language2 . ')',
            'text_4_3'       => Yii::t('cms', 'Text 4') . '(' . $language3 . ')',
            'text_4_4'       => Yii::t('cms', 'Text 4') . '(' . $language4 . ')',
            'text_5_0'       => Yii::t('cms', 'Text 5') . '(' . $language0 . ')',
            'text_5_1'       => Yii::t('cms', 'Text 5') . '(' . $language1 . ')',
            'text_5_2'       => Yii::t('cms', 'Text 5') . '(' . $language2 . ')',
            'text_5_3'       => Yii::t('cms', 'Text 5') . '(' . $language3 . ')',
            'text_5_4'       => Yii::t('cms', 'Text 5') . '(' . $language4 . ')',
            'text_6_0'       => Yii::t('cms', 'Text 6') . '(' . $language0 . ')',
            'text_6_1'       => Yii::t('cms', 'Text 6') . '(' . $language1 . ')',
            'text_6_2'       => Yii::t('cms', 'Text 6') . '(' . $language2 . ')',
            'text_6_3'       => Yii::t('cms', 'Text 6') . '(' . $language3 . ')',
            'text_6_4'       => Yii::t('cms', 'Text 6') . '(' . $language4 . ')',
            'text_7_0'       => Yii::t('cms', 'Text 7') . '(' . $language0 . ')',
            'text_7_1'       => Yii::t('cms', 'Text 7') . '(' . $language1 . ')',
            'text_7_2'       => Yii::t('cms', 'Text 7') . '(' . $language2 . ')',
            'text_7_3'       => Yii::t('cms', 'Text 7') . '(' . $language3 . ')',
            'text_7_4'       => Yii::t('cms', 'Text 7') . '(' . $language4 . ')',
            'file_1_0'       => Yii::t('cms', 'File 1') . '(' . $language0 . ')',
            'file_1_1'       => Yii::t('cms', 'File 1') . '(' . $language1 . ')',
            'file_1_2'       => Yii::t('cms', 'File 1') . '(' . $language2 . ')',
            'file_1_3'       => Yii::t('cms', 'File 1') . '(' . $language3 . ')',
            'file_1_4'       => Yii::t('cms', 'File 1') . '(' . $language4 . ')',
            'file_2_0'       => Yii::t('cms', 'File 2') . '(' . $language0 . ')',
            'file_2_1'       => Yii::t('cms', 'File 2') . '(' . $language1 . ')',
            'file_2_2'       => Yii::t('cms', 'File 2') . '(' . $language2 . ')',
            'file_2_3'       => Yii::t('cms', 'File 2') . '(' . $language3 . ')',
            'file_2_4'       => Yii::t('cms', 'File 2') . '(' . $language4 . ')',
            'file_3_0'       => Yii::t('cms', 'File 3') . '(' . $language0 . ')',
            'file_3_1'       => Yii::t('cms', 'File 3') . '(' . $language1 . ')',
            'file_3_2'       => Yii::t('cms', 'File 3') . '(' . $language2 . ')',
            'file_3_3'       => Yii::t('cms', 'File 3') . '(' . $language3 . ')',
            'file_3_4'       => Yii::t('cms', 'File 3') . '(' . $language4 . ')',
            'meta_title_0'   => Yii::t('cms', 'Seo Title') . '(' . $language0 . ')',
            'meta_des_0'     => Yii::t('cms', 'Seo Description') . '(' . $language0 . ')',
            'meta_keyword_0' => Yii::t('cms', 'Seo Keywords') . '(' . $language0 . ')',
            'meta_title_1'   => Yii::t('cms', 'Seo Title') . '(' . $language1 . ')',
            'meta_des_1'     => Yii::t('cms', 'Seo Description') . '(' . $language1 . ')',
            'meta_keyword_1' => Yii::t('cms', 'Seo Keywords') . '(' . $language1 . ')',
            'meta_title_2'   => Yii::t('cms', 'Seo Title') . '(' . $language2 . ')',
            'meta_des_2'     => Yii::t('cms', 'Seo Description') . '(' . $language2 . ')',
            'meta_keyword_2' => Yii::t('cms', 'Seo Keywords') . '(' . $language2 . ')',
            'meta_title_3'   => Yii::t('cms', 'Seo Title') . '(' . $language3 . ')',
            'meta_des_3'     => Yii::t('cms', 'Seo Description') . '(' . $language3 . ')',
            'meta_keyword_3' => Yii::t('cms', 'Seo Keywords') . '(' . $language3 . ')',
            'meta_title_4'   => Yii::t('cms', 'Seo Title') . '(' . $language4 . ')',
            'meta_des_4'     => Yii::t('cms', 'Seo Description') . '(' . $language4 . ')',
            'meta_keyword_4' => Yii::t('cms', 'Seo Keywords') . '(' . $language4 . ')',
            'date_0'         => Yii::t('cms', 'Date') . '(' . $language0 . ')',
            'date_1'         => Yii::t('cms', 'Date') . '(' . $language1 . ')',
            'date_2'         => Yii::t('cms', 'Date') . '(' . $language2 . ')',
            'date_3'         => Yii::t('cms', 'Date') . '(' . $language3 . ')',
            'date_4'         => Yii::t('cms', 'Date') . '(' . $language4 . ')',
            'status'         => Yii::t('cms', 'Status'),
            'created_at'     => Yii::t('cms', 'Created At'),
            'updated_at'     => Yii::t('cms', 'Updated At'),
            'created_by'     => Yii::t('cms', 'Created by'),
            'updated_by'     => Yii::t('cms', 'Updated by'),
            'files'          => Yii::t('cms', 'Pictures'),
            'views_count'    => Yii::t('cms', 'Views count'),

            'comments_count' => Yii::t('cms', 'Comment count'),
            'avarage_voting' => Yii::t('cms', 'Avarage voting'),
            'votes_count'    => Yii::t('cms', 'Votes Count'),
        ];
    }

    public function getOptionValue(CaE $cae)
    {
        return (isset($this->options[$cae->collection->slug]))
            ? $this->options[$cae->collection->slug]
            : (($cae->collection->optionDefault) ? $cae->collection->optionDefault->id : null);
    }

    public function getImageUrl(
        $attr,
        $width,
        $height,
        $operation = null,
        $background = null,
        $xPos = null,
        $yPos = null
    ) {
        return Image::get($this, $attr, $width, $height, $operation, $background, $xPos, $yPos);
    }

    public function isAttrDisabled($entityAttr)
    {
        return !($this->isAttrCommon($entityAttr) || $this->isAttrTranslatable($entityAttr));
    }

    public function isAttrCommon($entityAttr)
    {
        if (!$this->dependEntity) {
            $this->dependEntity = $this->entity;
        }

        switch ($this->dependEntity->{$entityAttr}) {
            case Entities::FILE_COMMON:
            case Entities::TEXT_COMMON_INPUT_STRING:
            case Entities::TEXT_COMMON_INPUT_STRING_REQUIRED:
            case Entities::TEXT_COMMON_INPUT_INT:
            case Entities::TEXT_COMMON_INPUT_INT_REQUIRED:
            case Entities::TEXT_COMMON_INPUT_URL:
            case Entities::TEXT_COMMON_INPUT_URL_REQUIRED:
            case Entities::TEXT_COMMON_TEXTAREA:
            case Entities::TEXT_COMMON_CKEDITOR:
                return true;
            case Entities::FILE_DISABLED:
            case Entities::TEXT_DISABLED:
                return Entities::DISABLED;
        }

        return false;
    }

    public function isAttrTranslatable($entityAttr)
    {
        if (!$this->dependEntity) {
            $this->dependEntity = $this->entity;
        }

        switch ($this->dependEntity->{$entityAttr}) {
            case Entities::FILE_TRANSLATABLE:
            case Entities::TEXT_TRANSLATABLE_INPUT_STRING:
            case Entities::TEXT_TRANSLATABLE_INPUT_STRING_REQUIRED:
            case Entities::TEXT_TRANSLATABLE_INPUT_INT:
            case Entities::TEXT_TRANSLATABLE_INPUT_INT_REQUIRED:
            case Entities::TEXT_TRANSLATABLE_INPUT_URL:
            case Entities::TEXT_TRANSLATABLE_INPUT_URL_REQUIRED:
            case Entities::TEXT_TRANSLATABLE_TEXTAREA:
            case Entities::TEXT_TRANSLATABLE_CKEDITOR:
                return true;
            case Entities::FILE_DISABLED:
            case Entities::TEXT_DISABLED:
                return Entities::DISABLED;
        }

        return false;
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

    public function getEntity()
    {
        return $this->hasOne(Entities::class, ['id' => 'entity_id']);
    }

    public function getCreatedBy()
    {
        return $this->hasOne(Module::getInstance()->userClass, ['id' => 'created_by']);
    }


    public function getUpdatedBy()
    {
        return $this->hasOne(Module::getInstance()->userClass, ['id' => 'updated_by']);
    }

    public function getOption()
    {
        return $this->hasOne(OaI::class, ['item_id' => 'id']);
    }


    public function getDate($format = null)
    {
        if ($format) {
            return date($format, $this->getDate());
        }

        return in_array($this->entity->use_date,
            [Entities::USE_DATE_DISABLED, Entities::USE_DATE_DATE, Entities::USE_DATE_DATETIME])
            ? $this['date_0']
            : $this['date_' . \Yii::$app->params['l'][\Yii::$app->language]];
    }

    #region Photo Methods

    public function getPhotos()
    {
        return $this->hasMany(ItemPhotos::class, ['cms_item_id' => 'id'])->orderBy('sort');
    }

    public function getMainPhoto()
    {
        return $this->hasOne(ItemPhotos::class, ['id' => 'main_photo_id']);
    }

    public function addPhoto(UploadedFile $file): void
    {
        $photos   = $this->photos;
        $photos[] = ItemPhotos::create($file, $this->id);
        $this->updatePhotos($photos);
    }

    private function updatePhotos(array $photos): void
    {
        foreach ($photos as $i => $photo) {
            $photo->setSort($i);
            $photo->save();
        }
        $this->setMainPhoto($photos);
    }

    public function getGalleryPhoto(
        $width = null,
        $height = null,
        $operation = null,
        $background = null,
        $xPos = null,
        $yPos = null
    ) {
        return $this->mainPhoto ? $this->mainPhoto->getPhoto($width, $height, $operation, $background, $xPos,
            $yPos) : '';
    }

    public function setMainPhoto($photos)
    {
        if (!empty($photos)) {
            $model                = self::findOne($this->id);
            $model->main_photo_id = $photos[0]['id'] ?? $photos[1]['id'];
            $model->save(false);
        }
    }

    public function removePhotos(): void
    {
        $this->updatePhotos([]);
    }

    public function movePhotoUp($id): void
    {
        $photos = $this->photos;
        foreach ($photos as $i => $photo) {
            if ($photo->isIdEqualTo($id)) {
                if ($prev = $photos[$i - 1] ?? null) {
                    $photos[$i - 1] = $photo;
                    $photos[$i]     = $prev;
                    $this->updatePhotos($photos);
                }

                return;
            }
        }
        throw new DomainException(Yii::t('app', 'Photo is not found.'));
    }

    public function movePhotoDown($id): void
    {
        $photos = $this->photos;
        foreach ($photos as $i => $photo) {
            if ($photo->isIdEqualTo($id)) {
                if ($next = $photos[$i + 1] ?? null) {
                    $photos[$i]     = $next;
                    $photos[$i + 1] = $photo;
                    $this->updatePhotos($photos);
                }

                return;
            }
        }
        throw new DomainException(Yii::t('app', 'Photo is not found.'));
    }

    public function removePhoto($id): void
    {
        $photos = $this->photos;
        foreach ($photos as $i => $photo) {
            if ($photo->isIdEqualTo($id)) {
                $photo->delete();
                unset($photos[$i]);
                $this->updatePhotos($photos);

                return;
            }
        }
        throw new DomainException(Yii::t('app', 'Photo is not found.'));
    }

    #endregion

    #endregion

    public function addComment($comment): void
    {
        $count       = $this->comments_count;
        $avarage     = $this->avarage_voting;
        $count_votes = $this->votes_count;

        $this->comments_count = $count + 1;

        if ($comment->vote) {
            $count_votes++;
            $this->votes_count    = $count_votes;
            $this->avarage_voting = $this->votes_count != 0 ? ((($count_votes - 1) * $avarage + $comment->vote) / $count_votes) : 0;
        }
        $this->save();
    }

    public function deleteComment($comment): void
    {
        $count       = $this->comments_count;
        $avarage     = $this->avarage_voting;
        $count_votes = $this->votes_count;

        $this->comments_count = $count - 1;

        if ($comment->vote) {
            $count_votes--;
            $this->votes_count    = $count_votes;
            $this->avarage_voting = $count_votes != 0 ? ((($count_votes + 1) * $avarage - $comment->vote) / $count_votes) : 0;
        }

        $this->save();
    }

    public function calculateCommentsAndVotes()
    {
        $count_comments       = ItemComments::find()->where([
            'item_id' => $this->id,
            'status'  => ItemComments::STATUS_CHECKED,
        ])->andWhere(['is not', 'text', null])->count();
        $count_votes          = ItemComments::find()->where([
            'item_id' => $this->id,
            'status'  => ItemComments::STATUS_CHECKED,
        ])->andWhere(['is not', 'vote', null])->count();
        $summ_votes           = ItemComments::find()->where([
            'item_id' => $this->id,
            'status'  => ItemComments::STATUS_CHECKED,
        ])->andWhere(['is not', 'vote', null])->sum('vote');
        $this->votes_count    = $count_votes;
        $this->comments_count = $count_comments;
        $this->avarage_voting = $count_votes == 0 ? 0 : $summ_votes / $count_votes;
        $this->save();
    }
}
