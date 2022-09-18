<?php

namespace afzalroq\cms\entities\unit;

use afzalroq\cms\helpers\UnitType;
use afzalroq\cms\validators\SlugValidator;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\caching\TagDependency;
use yii\helpers\ArrayHelper;

/**
 * @property int $id
 * @property int $category_id
 * @property int $sort
 * @property int $size
 * @property string $label
 * @property string $slug
 * @property string $type
 * @property int $inputValidator
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Categories $category
 */
class Unit extends \yii\db\ActiveRecord
{

    public static function get($slug)
    {
        return Yii::$app->{Yii::$app->getModule('cms')->cache}->getOrSet('unit' . $slug . Yii::$app->language, function () use ($slug) {
            return self::findOne(['slug' => $slug])->getModelByType()->get();
        }, Yii::$app->getModule('cms')->cacheDuration, new TagDependency(['tags' => ['unit']]));
    }

    public function getModelByType()
    {
        switch ($this->type) {
            case UnitType::FILES:
            case UnitType::FILE_COMMON:
                return File::findOne($this->id);
            case UnitType::IMAGES:
            case UnitType::IMAGE_COMMON:
                return Image::findOne($this->id);
            case UnitType::STRINGS:
            case UnitType::STRING_COMMON:
            case UnitType::TEXTS:
            case UnitType::TEXT_COMMON:
                return Text::findOne($this->id);
            case UnitType::INPUTS:
            case UnitType::INPUT_COMMON:
                return TextInput::findOne($this->id);
        }
    }

    public static function getPhotoUrl($object, $thumbProfile = null): string
    {
        $key = \Yii::$app->params['l'][\Yii::$app->language];

        if (!$object['photo_' . $key]) $key = 0;

        return $thumbProfile ? $object->getThumbFileUrl('photo_' . $key, $thumbProfile) : $object->getImageFileUrl('photo_' . $key);
    }

    public static function getBySlug($slug)
    {
        return self::find()
            ->where(['category_id' => (Categories::findOne(['slug' => $slug]))->id])
            ->orderBy('sort')
            ->all();
    }

    public static function tableName()
    {
        return 'cms_unit_units';
    }

    public function rules()
    {
        return [
            [['category_id'], 'required'],
            [['category_id'], 'integer'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::class, 'targetAttribute' => ['category_id' => 'id']],

            [['sort'], 'required'],
            [['sort'], 'integer'],

            ['slug', 'required'],
            ['slug', 'string', 'max' => 255],
            ['slug', 'unique'],
            ['slug', SlugValidator::class],

            ['label', 'required'],
            ['label', 'string', 'max' => 255],

            ['size', 'required'],
            ['size', 'integer', 'min' => 1, 'max' => 12],

            ['inputValidator', 'integer'],

            ['type', 'required'],
            [['type'], 'in', 'range' => array_keys(UnitType::list())],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => Yii::t('unit', 'ID'),
            'category_id' => Yii::t('unit', 'Category'),
            'sort' => Yii::t('unit', 'Sort'),
            'size' => Yii::t('unit', 'Size'),
            'type' => Yii::t('unit', 'Type'),
            'inputValidator' => Yii::t('unit', 'Validator'),
            'label' => Yii::t('unit', 'Label'),
            'slug' => Yii::t('unit', 'Slug'),
            'created_at' => Yii::t('unit', 'Created At'),
            'updated_at' => Yii::t('unit', 'Updated At'),
        ];
    }

    public function getSortValue($categoryId)
    {
        return $this->isNewRecord ? (self::find()->where(['category_id' => $categoryId])->max('sort') + 1) : $this->sort;
    }

    public function getCategory()
    {
        return $this->hasOne(Categories::class, ['id' => 'category_id']);
    }

    public function categoriesList()
    {
        return ArrayHelper::map(Categories::find()->asArray()->all(), 'id', 'title_0');
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        TagDependency::invalidate(Yii::$app->{Yii::$app->getModule('cms')->cache}, 'unit');
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }
}
