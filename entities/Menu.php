<?php

namespace afzalroq\cms\entities;

use afzalroq\cms\entities\query\MenuQuery;
use creocoder\nestedsets\NestedSetsBehavior;
use Yii;
use yii\base\BaseObject;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\caching\TagDependency;
use yii\db\ActiveRecord;
use yii\db\Exception;
use yii\helpers\Html;
use yii\helpers\Url;
use afzalroq\cms\Module;



/**
 * This is the model class for table "menu".
 *
 * @property int $id
 * @property string $title_0
 * @property string $title_1
 * @property string $title_2
 * @property string $title_3
 * @property string $title_4
 * @property int $type
 * @property string $type_helper
 * @property int $menu_type_id
 * @property int $created_at
 * @property int $updated_at
 * @property MenuType $menuType
 */
class Menu extends ActiveRecord
{
    #region Constants
    const TYPE_EMPTY = 1;
    const TYPE_ACTION = 2;
    const TYPE_LINK = 3;
    const TYPE_OPTION = 4;
    const TYPE_ITEM = 5;
    const TYPE_COLLECTION = 6;
    const TYPE_ENTITY = 7;
    const TYPE_ENTITY_ITEM = 10;
    #endregion

    #region Extra Attributes

    public $types;
    public $types_helper;
    public $option_id;
    public $dependMenuType;

    public $action;
    public $link;
    public $treeAttribute = 'tree';
    private $CMSModule;


    #endregion

    #region Overrides

    public function __construct($config = [])
    {
        $this->CMSModule = Yii::$app->getModule('cms');
        parent::__construct($config);
    }

    public static function tableName()
    {
        return 'cms_menu';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class,
            'tree' => [
                'class' => NestedSetsBehavior::class,
                'treeAttribute' => $this->treeAttribute,
                // 'leftAttribute' => 'lft',
                // 'rightAttribute' => 'rgt',
                // 'depthAttribute' => 'depth',
            ]
        ];
    }

    public static function find()
    {
        return new MenuQuery(get_called_class());
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert))
            return false;
        $this->dependMenuType = MenuType::findOne(['id' => $this->menu_type_id]);
        switch ($this->type) {
            case self::TYPE_ITEM:
                $this->type_helper = explode('_', $this->types)[1] . ',' . $this->type_helper;
                break;
        }

        return true;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        TagDependency::invalidate(Yii::$app->{Yii::$app->getModule('cms')->cache}, 'menu_' . $this->dependMenuType->slug);

        return true;
    }

    public function afterDelete()
    {
        parent::afterDelete();
        $this->dependMenuType = MenuType::findOne(['id' => $this->menu_type_id]);
        TagDependency::invalidate(Yii::$app->{Yii::$app->getModule('cms')->cache}, 'menu_' . $this->dependMenuType->slug);
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
            ['title_4', 'required', 'when' => function () {
                return in_array(4, Yii::$app->params['cms']['languageIds']);
            }],
            [['title_0', 'title_1', 'title_2', 'title_3', 'title_4'], 'string', 'max' => 255],

            [['type', 'menu_type_id'], 'required'],
            [['type', 'menu_type_id'], 'integer'],
            ['types', 'string'],
            ['type_helper', 'string'],
            ['types_helper', 'string'],

            ['action', 'in', 'range' => self::actionsList(true), 'allowArray' => true, 'when' => function ($model) {
                return $model->type == self::TYPE_ACTION;
            }, 'enableClientValidation' => false],

            ['link', 'required', 'when' => function ($model) {
                return $model->type == self::TYPE_LINK;
            }, 'enableClientValidation' => false],
            ['link', 'string', 'when' => function ($model) {
                return $model->type == self::TYPE_LINK;
            }, 'enableClientValidation' => false],

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
            'title_0' => Yii::t('cms', 'Title') . '(' . $language0 . ')',
            'title_1' => Yii::t('cms', 'Title') . '(' . $language1 . ')',
            'title_2' => Yii::t('cms', 'Title') . '(' . $language2 . ')',
            'title_3' => Yii::t('cms', 'Title') . '(' . $language3 . ')',
            'title_4' => Yii::t('cms', 'Title') . '(' . $language4 . ')',
            'type' => Yii::t('cms', 'Type'),
            'types' => Yii::t('cms', 'Type'),
            'type_helper' => Yii::t('cms', 'Type Helper'),
            'action' => Yii::t('cms', 'Module action'),
            'link' => Yii::t('cms', 'link'),
            'page_id' => Yii::t('cms', 'Page'),
            'articles_category_id' => Yii::t('cms', 'Articles'),
            'created_at' => Yii::t('cms', 'Created At'),
            'updated_at' => Yii::t('cms', 'Updated At'),
        ];
    }

    #endregion

    #region Extra Methods

    // Collections, Options and Entities List for use in menu
    public function COEList()
    {
        $entities = [];
        $collections = [];
        $options = [];

        /** @var Collections $collection */
        foreach (Collections::find()->all() as $collection)
            switch ($collection->use_in_menu) {
                case Collections::USE_IN_MENU_OPTIONS:
                    $collections[] = [
                        'id' => $collection->id,
                        'name' => $collection->name_0
                    ];
                    break;
                case Collections::USE_IN_MENU_ITEMS:
                    foreach (Options::findAll(['collection_id' => $collection->id]) as $option)
                        $options[] = [
                            'id' => $option->id,
                            'name' => $option->slug
                        ];
                    break;
                default:
                    break;
            }


        /** @var Entities $entity */
        foreach (Entities::find()->all() as $entity)
            if ($entity->use_in_menu)
                $entities[] = [
                    'id' => $entity->id,
                    'name' => $entity->name_0
                ];

        return [$collections, $entities, $options];
    }

    public function actionsList($flip = false)
    {
        $array = [];
        if (is_string($flip) && array_key_exists($flip, $this->CMSModule->menuActions))
            return $array[$flip];
        elseif ($flip)
            return array_flip($this->CMSModule->menuActions);
        return $this->CMSModule->menuActions;
    }

    public function initForUpdate()
    {
        $options = '';
        switch ($this->type) {
            case self::TYPE_EMPTY:
                $this->types = 'type_' . $this->type;
                break;

            case self::TYPE_ACTION:
                $this->types = 'action_' . $this->type_helper;
                break;

            case self::TYPE_LINK:
                $this->types = 'type_' . $this->type;
                $this->link = $this->type_helper;
                break;

            case self::TYPE_OPTION:
                $dependOption = Options::findOne($this->type_helper);
                $options .= '<option value=' . $dependOption->collection_id . '_collection>self</option>';

                foreach (Options::findAll(['collection_id' => $dependOption->collection_id]) as $option)
                    $options .= '<option ' . (($this->type_helper == $option->id) ? 'selected' : '') . ' value=' . $option->id . '>' . $option->name_0 . '</option>';

                $this->types = 'collection_' . $dependOption->collection_id;
                $this->types_helper = $options;
                break;

            case self::TYPE_ITEM:
                [$option_id, $item_id] = explode(',', $this->type_helper);

                foreach (OaI::findAll(['option_id' => $option_id]) as $oai)
                    $options .= '<option ' . (($oai->item_id == $item_id) ? 'selected' : '') . ' value=' . $oai->item_id . '>' . $oai->item->text_1_0 . '</option>';

                $this->types = 'option_' . $option_id;
                $this->types_helper = $options;
                $this->option_id = $option_id;
                $this->type_helper = $item_id;
                break;

            case self::TYPE_ENTITY_ITEM:
                if ($dependItem = Items::findOne($this->type_helper)) {
                    $this->types = 'entity_' . $dependItem->entity_id;
                    $options .= '<option value=' . $dependItem->entity_id . '_entity>self</option>';
                    foreach (Items::findAll(['entity_id' => $dependItem->entity_id]) as $item)
                        $options .= '<option ' . (($item->id == $this->type_helper) ? 'selected' : '') . ' value=' . $item->id . '>' . $item->text_1_0 . '</option>';
                }

                $this->types_helper = $options;
                break;

            case self::TYPE_COLLECTION:
                $dependOption = Options::findOne($this->type_helper);
                $options .= '<option selected value=' . $dependOption->collection_id . '_collection>self</option>';
                foreach (Options::findAll(['collection_id' => $dependOption->collection_id]) as $option)
                    $options .= '<option value=' . $option->id . '>' . $option->name_0 . '</option>';

                $this->types = 'collection_' . $dependOption->collection_id;
                $this->types_helper = $options;
                break;

            case self::TYPE_ENTITY:
                $dependItem = Items::findOne($this->type_helper);
                $options .= '<option selected value=' . $dependItem->entity_id . '_entity>self</option>';

                foreach (Items::findAll(['entity_id' => $dependItem->entity_id]) as $item)
                    $options .= '<option  value=' . $item->id . '>' . $item->text_1_0 . '</option>';

                $this->types = 'entity_' . $dependItem->entity_id;
                $this->types_helper = $options;
                break;
            default:
                $this->type_helper = '';
        }
    }


    public function getMenuType()
    {
        $this->hasOne(MenuType::class, ['id' => 'menu_typ_id']);
    }

    public function getCreatedBy()
    {
        return $this->hasOne(Module::getInstance()->userClass, ['id' => 'created_by']);
    }


    public function getUpdatedBy()
    {
        return $this->hasOne(Module::getInstance()->userClass, ['id' => 'updated_by']);
    }

    public function typesList($key = null)
    {
        $a = [];
        $a[self::TYPE_EMPTY] = 'Элемент меню для вложения подменю';
        $a[self::TYPE_LINK] = 'Ссылка';
        return ($key && isset($a[$key])) ? $a[$key] : $a;
    }

    public function typesLists($key = null)
    {
        $a = [];
        $a[self::TYPE_EMPTY] = 'Элемент меню для вложения подменю';
        $a[self::TYPE_LINK] = 'Ссылка';
        $a[self::TYPE_ACTION] = 'Action';
        $a[self::TYPE_OPTION] = 'Option';
        $a[self::TYPE_ITEM] = 'Option Item';
        $a[self::TYPE_COLLECTION] = 'Collection';
        $a[self::TYPE_ENTITY] = 'Entity';
        $a[self::TYPE_ENTITY_ITEM] = 'Item';

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

            case self::TYPE_OPTION:
                $option = Options::findOne($this->type_helper);
                return Html::a($option->name_0, Url::to(['options/view', 'id' => $option->id, 'slug' => $option->collection->slug]));

            case self::TYPE_ITEM:
                return Options::findOne($this->option_id)->name_0 . ', ' . Items::findOne($this->type_helper)->text_1_0;

            case self::TYPE_ENTITY_ITEM:
                $item = Items::findOne($this->type_helper);
                return Html::a($item->text_1_0, Url::to(['items/view', 'id' => $this->type_helper, 'slug' => $item->entity->slug]));

            case self::TYPE_COLLECTION:
                $collection = Collections::findOne($this->type_helper);
                return Html::a($collection->name_0, Url::to(['collections/view', 'id' => $this->type_helper]));

            case self::TYPE_ENTITY:
                $entity = Entities::findOne($this->type_helper);
                return Html::a($entity->name_0, Url::to(['entities/view', 'id' => $this->type_helper]));
            default:
                return $this->type_helper;
        }
    }

    public static function getTypes()
    {
        return [
            self::TYPE_EMPTY,
            self::TYPE_ACTION,
            self::TYPE_LINK,
            self::TYPE_OPTION,
            self::TYPE_ITEM,
            self::TYPE_COLLECTION,
            self::TYPE_ENTITY,
            self::TYPE_ENTITY_ITEM
        ];
    }

    //    public function getMaxSort()
    //    {
    //        return ((new ActiveQuery(self::class))
    //                ->from(self::tableName())
    //                ->max('sort')) + 1;
    //    }

    #endregion
}
