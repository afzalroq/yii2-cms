<?php

namespace abdualiym\cms\entities;

use abdualiym\slider\entities\Categories;
use abdualiym\slider\entities\Slides;
use Yii;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yiidreamteam\upload\ImageUploadBehavior;

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
class Articles extends \yii\db\ActiveRecord
{
    private $CMSModule;

    public function __construct($config = [])
    {
        $this->CMSModule = Yii::$app->getModule('cms');
        parent::__construct($config);
    }

    public static function tableName()
    {
        return 'abdualiym_cms_articles';
    }

    public function rules()
    {
        return [
            ['title_0', 'required', 'when' => function () {
                return in_array(0, Yii::$app->params['cms']['languageIds']);
            }],
            ['title_1', 'required', 'when' => function () {
                return in_array(1, Yii::$app->params['cms']['languageIds']);
            }],
            ['title_2', 'required', 'when' => function () {
                return in_array(2, Yii::$app->params['cms']['languageIds']);
            }],
            ['title_3', 'required', 'when' => function () {
                return in_array(3, Yii::$app->params['cms']['languageIds']);
            }],
            [['title_0', 'title_1', 'title_2', 'title_3'], 'string', 'max' => 255],

            [['content_0', 'content_1', 'content_2', 'content_3'], 'string'],

            [['category_id'], 'required'],
            [['category_id'], 'integer'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ArticleCategories::class, 'targetAttribute' => ['category_id' => 'id']],

            [['status'], 'boolean'],
            [['status'], 'default', 'value' => true],

            [['date'], 'string', 'max' => 10],

            ['photo', 'image'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        $language0 = isset(Yii::$app->params['cms']['languages2'][0]) ? Yii::$app->params['cms']['languages2'][0] : '';
        $language1 = isset(Yii::$app->params['cms']['languages2'][1]) ? Yii::$app->params['cms']['languages2'][1] : '';
        $language2 = isset(Yii::$app->params['cms']['languages2'][2]) ? Yii::$app->params['cms']['languages2'][2] : '';
        $language3 = isset(Yii::$app->params['cms']['languages2'][3]) ? Yii::$app->params['cms']['languages2'][3] : '';

        return [
            'id' => Yii::t('cms', 'ID'),
            'title_0' => Yii::t('cms', 'Title') . '(' . $language0 . ')',
            'title_1' => Yii::t('cms', 'Title') . '(' . $language1 . ')',
            'title_2' => Yii::t('cms', 'Title') . '(' . $language2 . ')',
            'title_3' => Yii::t('cms', 'Title') . '(' . $language3 . ')',
            'slug' => Yii::t('cms', 'Slug'),
            'category_id' => Yii::t('cms', 'Category'),
            'date' => Yii::t('cms', 'Date'),
            'status' => Yii::t('cms', 'Status'),
            'photo' => Yii::t('cms', 'Photo'),
            'content_0' => Yii::t('cms', 'Content') . '(' . $language0 . ')',
            'content_1' => Yii::t('cms', 'Content') . '(' . $language1 . ')',
            'content_2' => Yii::t('cms', 'Content') . '(' . $language2 . ')',
            'content_3' => Yii::t('cms', 'Content') . '(' . $language3 . ')',
            'created_at' => Yii::t('cms', 'Created At'),
            'updated_at' => Yii::t('cms', 'Updated At'),
        ];
    }


    public function getCategory()
    {
        return $this->hasOne(ArticleCategories::class, ['id' => 'category_id']);
    }

    public function categoriesList()
    {
        return ArrayHelper::map(ArticleCategories::find()->asArray()->all(), 'id', 'title_0');
    }

    public function behaviors()
    {
        $module = Yii::$app->getModule('cms');

        return [
            TimestampBehavior::class,
            [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['date'],
                    ActiveRecord::EVENT_BEFORE_INSERT => ['date'],
                ],
                'value' => function ($event) {
                    return (int)strtotime($this->date);
                },
            ],
            'slug' => [
                'class' => 'Zelenin\yii\behaviors\Slug',
                'slugAttribute' => 'slug',
                'attribute' => 'title_0',
                // optional params
                'ensureUnique' => true,
                'replacement' => '-',
                'lowercase' => true,
                // false = changes after every change for $attribute
                'immutable' => false,
                // If intl extension is enabled, see http://userguide.icu-project.org/transforms/general.
                'transliterateOptions' => 'Russian-Latin/BGN; Any-Latin; Latin-ASCII; NFD; [:Nonspacing Mark:] Remove; NFC;'
            ],
            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'photo',
                'createThumbsOnRequest' => true,
                'filePath' => $module->storageRoot . '/data/articles/[[attribute_id]]/[[filename]].[[extension]]',
                'fileUrl' => $module->storageHost . '/data/articles/[[attribute_id]]/[[filename]].[[extension]]',
                'thumbPath' => $module->storageRoot . '/cache/articles/[[attribute_id]]/[[profile]]_[[filename]].[[extension]]',
                'thumbUrl' => $module->storageHost . '/cache/articles/[[attribute_id]]/[[profile]]_[[filename]].[[extension]]',
                'thumbs' => array_merge(
                    [
                        'sm' => ['width' => 106, 'height' => 60],
                        'md' => ['width' => 212, 'height' => 120],
                    ],
                    $module->thumbs
                )
            ]
        ];
    }

}
