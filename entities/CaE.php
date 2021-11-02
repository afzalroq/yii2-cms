<?php

namespace afzalroq\cms\entities;

use phpDocumentor\Reflection\Types\Null_;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "cms_collections_and_entities".
 *
 * @property int $id
 * @property int|null $collection_id
 * @property int|null $entity_id
 * @property int|null $type
 * @property int $sort
 * @property int|null $size
 * @property int $created_at
 * @property int $updated_at
 * @property int $location

 *

 * @property Collections $collection
 * @property Entities $entity
 */
class CaE extends ActiveRecord
{
    const TYPE_CHECKBOX = 0;
    const TYPE_SELECT = 1;
    const TYPE_RADIO = 2;

    const Location_Top = 0;
    const Location_Bottom = 1;


    public static function tableName()
    {
        return 'cms_collections_and_entities';
    }

    public static function typeList()
    {
        return [
            self::TYPE_CHECKBOX => Yii::t('cms', 'Checkbox'),
            self::TYPE_SELECT => Yii::t('cms', 'Select'),
            self::TYPE_RADIO => Yii::t('cms', 'Radio'),
        ];
    }

    public static function typeLocation()
    {
        return [
            Null => '--',
            self::Location_Top => Yii::t('cms', 'Top'),
            self::Location_Bottom => Yii::t('cms', 'Bottom'),
        ];
    }

    public function getUnassignedCollections(Entities $entity, $exceptCollectionId = null)
    {
        /** @var Collections[] $collections */
        $collections = Collections::find()->all();
        foreach ($collections as $key => $collection)
            foreach ($entity->caes as $cae) {
                if ($exceptCollectionId === $collection->id)
                    continue;

                if ($collection->id === $cae->collection_id)
                    unset($collections[$key]);
            }

        return $collections;
    }

    public function getOptionList()
    {
        $options = $this->collection->options;
        usort($options, function ($a, $b) {
            if ($a->sort == $b->sort)
                return 0;
            return ($a->sort < $b->sort) ? -1 : 1;
        });
        foreach ($options as $key => $option) {
            if ($option->depth === 0) {
                unset($options[$key]);
            }
        }

        return ArrayHelper::map($options, 'id', 'name_'. Yii::$app->params['l'][Yii::$app->language]);
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class
        ];
    }

    public function rules()
    {
        return [
            [['collection_id', 'entity_id', 'sort'], 'required'],
            [['collection_id', 'entity_id', 'type', 'location', 'sort', 'size'], 'integer'],
            [['collection_id'], 'exist', 'skipOnError' => true, 'targetClass' => Collections::class, 'targetAttribute' => ['collection_id' => 'id']],
            [['entity_id'], 'exist', 'skipOnError' => true, 'targetClass' => Entities::class, 'targetAttribute' => ['entity_id' => 'id']],
            [['location'], 'default', 'value'=> 0],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('cms', 'ID'),
            'collection_id' => Yii::t('cms', 'Collection'),
            'entity_id' => Yii::t('cms', 'Entity'),
            'type' => Yii::t('cms', 'Type'),
            'sort' => Yii::t('cms', 'Sort'),
            'size' => Yii::t('cms', 'Size'),
            'location' => Yii::t('cms','Location'),
            'created_at' => Yii::t('cms', 'Created At'),
            'updated_at' => Yii::t('cms', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Collection]].
     *
     * @return ActiveQuery
     */
    public function getCollection()
    {
        return $this->hasOne(Collections::class, ['id' => 'collection_id']);
    }

    /**
     * Gets query for [[Entity]].
     *
     * @return ActiveQuery
     */
    public function getEntity()
    {
        return $this->hasOne(Entities::class, ['id' => 'entity_id']);
    }
}
