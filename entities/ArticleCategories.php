<?php

namespace abdualiym\cms\entities;

use abdualiym\cms\validators\SlugValidator;
use common\helpers\Language;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "article_categories".
 *
 * @property int $id
 * @property string $title_0
 * @property string $title_1
 * @property string $title_2
 * @property string $title_3
 * @property string $slug
 * @property string $description_0
 * @property string $description_1
 * @property string $description_2
 * @property string $description_3
 * @property int $created_at
 * @property int $updated_at
 */
class ArticleCategories extends \yii\db\ActiveRecord
{
    private $CMSModule;

    public function __construct($config = [])
    {
        $this->CMSModule = Yii::$app->getModule('cms');
        parent::__construct($config);
    }

    public static function tableName()
    {
        return 'abdualiym_cms_article_categories';
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

            [['title_0', 'title_1', 'title_2', 'title_3', 'slug'], 'string', 'max' => 255],
            ['slug', 'required'],
            [['slug'], 'unique'],
            [['slug'], SlugValidator::class],

            [['description_0', 'description_1', 'description_2', 'description_3'], 'string'],
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
            'description_0' => Yii::t('cms', 'Description') . '(' . $language0 . ')',
            'description_1' => Yii::t('cms', 'Description') . '(' . $language1 . ')',
            'description_2' => Yii::t('cms', 'Description') . '(' . $language2 . ')',
            'description_3' => Yii::t('cms', 'Description') . '(' . $language3 . ')',
            'created_at' => Yii::t('cms', 'Created At'),
            'updated_at' => Yii::t('cms', 'Updated At'),
        ];
    }


    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }
}
