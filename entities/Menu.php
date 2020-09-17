<?php

namespace abdualiym\cms\entities;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "menu".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $title_0
 * @property string $title_1
 * @property string $title_2
 * @property string $title_3
 * @property int $type
 * @property string $type_helper
 * @property string $action
 * @property string $link
 * @property int $page_id
 * @property int $articles_category_id
 * @property int $sort
 * @property int $created_at
 * @property int $updated_at
 */
class Menu extends \yii\db\ActiveRecord
{
    const TYPE_EMPTY = 1;
    const TYPE_ACTION = 2;
    const TYPE_LINK = 3;
    const TYPE_PAGE = 4;
    const TYPE_ARTICLES_CATEGORY = 5;

    public $action;
    public $page_id;
    public $link;
    public $articles_category_id;

    private $CMSModule;

    public function __construct($config = [])
    {
        $this->CMSModule = Yii::$app->getModule('cms');
        parent::__construct($config);
    }

    public static function tableName()
    {
        return 'abdualiym_cms_menu';
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

            [['type'], 'required'],
            ['type', 'integer'],

            [['parent_id', 'sort'], 'integer'],

//            ['action', 'required', 'when' => function ($model) {
//                return $model->type == self::TYPE_ACTION;
//            }, 'enableClientValidation' => false],
            ['action', 'in', 'range' => self::actionsList(true), 'allowArray' => true, 'when' => function ($model) {
                return $model->type == self::TYPE_ACTION;
            }, 'enableClientValidation' => false],

            ['link', 'required', 'when' => function ($model) {
                return $model->type == self::TYPE_LINK;
            }, 'enableClientValidation' => false],
            ['link', 'string', 'when' => function ($model) {
                return $model->type == self::TYPE_LINK;
            }, 'enableClientValidation' => false],

            ['page_id', 'required', 'when' => function ($model) {
                return $model->type == self::TYPE_PAGE;
            }, 'enableClientValidation' => false],
            ['page_id', 'exist', 'targetClass' => Pages::class, 'targetAttribute' => 'id', 'when' => function ($model) {
                return $model->type == self::TYPE_PAGE;
            }, 'enableClientValidation' => false],

            ['articles_category_id', 'required', 'when' => function ($model) {
                return $model->type == self::TYPE_ARTICLES_CATEGORY;
            }, 'enableClientValidation' => false],
            ['articles_category_id', 'exist', 'targetClass' => ArticleCategories::class, 'targetAttribute' => 'id', 'when' => function ($model) {
                return $model->type == self::TYPE_ARTICLES_CATEGORY;
            }, 'enableClientValidation' => false],
        ];
    }

    public function actionsList($flip = false)
    {
        if (is_string($flip) && array_key_exists($flip, $this->CMSModule->menuActions))
            return $array[$flip];
        elseif ($flip)
            return array_flip($this->CMSModule->menuActions);
        return $this->CMSModule->menuActions;
    }

    public function typesList($key = null)
    {
        $a = [];
        $a[self::TYPE_EMPTY] = 'Элемент меню для вложения подменю';
        $a[self::TYPE_ACTION] = 'Предопределенный модул';
        $a[self::TYPE_LINK] = 'Ссылка';
        $a[self::TYPE_PAGE] = 'Страница сайта';
        $a[self::TYPE_ARTICLES_CATEGORY] = 'Категория статьей';

        if ($key && isset($a[$key])) {
            return $a[$key];
        } else {
            return $a;
        }
    }

    public function getTypeValue()
    {
        switch ($this->type) {
            case self::TYPE_ACTION:
                return $this->CMSModule->menuActions[$this->type_helper];
                break;
            case self::TYPE_LINK:
                return $this->type_helper;
                break;
            case self::TYPE_PAGE:
                return Pages::findOne($this->type_helper)->title_0;
                break;
            case self::TYPE_ARTICLES_CATEGORY:
                return ArticleCategories::findOne($this->type_helper)->title_0;
                break;
            default:
                return $this->type_helper;
        }
    }

    public function getParents()
    {
        return $this->hasOne(self::class, ['id' => 'parent_id'])->from('menu' . ' m');
    }

    public function getPage()
    {
        return $this->hasOne(Pages::class, ['id' => 'page_id']);
    }

    public function getArticlesCategory()
    {
        return $this->hasOne(ArticleCategories::class, ['id' => 'articles_category_id']);
    }

    public function getParent()
    {
        return $this->hasOne(self::class, ['id' => 'parent_id']);
    }

    public function attributeLabels()
    {
        $language0 = isset(Yii::$app->params['cms']['languages2'][0]) ? Yii::$app->params['cms']['languages2'][0] : '';
        $language1 = isset(Yii::$app->params['cms']['languages2'][1]) ? Yii::$app->params['cms']['languages2'][1] : '';
        $language2 = isset(Yii::$app->params['cms']['languages2'][2]) ? Yii::$app->params['cms']['languages2'][2] : '';
        $language3 = isset(Yii::$app->params['cms']['languages2'][3]) ? Yii::$app->params['cms']['languages2'][3] : '';

        return [
            'id' => Yii::t('cms', 'ID'),
            'parent_id' => Yii::t('cms', 'Parent ID'),
            'title_0' => Yii::t('cms', 'Title') . '(' . $language0 . ')',
            'title_1' => Yii::t('cms', 'Title') . '(' . $language1 . ')',
            'title_2' => Yii::t('cms', 'Title') . '(' . $language2 . ')',
            'title_3' => Yii::t('cms', 'Title') . '(' . $language3 . ')',
            'type' => Yii::t('cms', 'Type'),
            'type_helper' => Yii::t('cms', 'Type Helper'),
            'action' => Yii::t('cms', 'Module action'),
            'link' => Yii::t('cms', 'link'),
            'page_id' => Yii::t('cms', 'Page'),
            'articles_category_id' => Yii::t('cms', 'Articles'),
            'sort' => Yii::t('cms', 'Sort'),
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

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            switch ($this->type) {
                case self::TYPE_ACTION:
                    $this->type_helper = $this->action;
                    break;
                case self::TYPE_LINK:
                    $this->type_helper = $this->link;
                    break;
                case self::TYPE_PAGE:
                    $this->type_helper = $this->page_id;
                    break;
                case self::TYPE_ARTICLES_CATEGORY:
                    $this->type_helper = $this->articles_category_id;
                    break;
                default: // empty
                    $this->type_helper = '';
            }

            return true;
        }

        return false;
    }

    public function afterFind()
    {
        switch ($this->type) {
            case self::TYPE_ACTION:
                $this->action = $this->type_helper;
                break;
            case self::TYPE_LINK:
                $this->link = $this->type_helper;
                break;
            case self::TYPE_PAGE:
                $this->page_id = $this->type_helper;
                break;
            case self::TYPE_ARTICLES_CATEGORY:
                $this->articles_category_id = $this->type_helper;
                break;
//            default:
//                $this->type_helper = '';
        }
        parent::afterFind();
    }

}
