<?php

namespace afzalroq\cms\entities;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "cms_options_and_menu_types".
 *
 * @property int $id
 * @property int|null $option_id
 * @property int|null $menu_type_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Collections $collection
 * @property Entities $entity
 */
class CaM extends ActiveRecord
{


    public $collection_id;
    public static function tableName()
    {
        return 'cms_options_and_menu_types';
    }

    public static function CollectionsList()
    {
        return Collections::find()->all();
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
            [['option_id','collection_id' ,'menu_type_id'], 'required'],
            [['option_id', 'menu_type_id'], 'integer'],
            [['option_id'], 'exist', 'skipOnError' => true, 'targetClass' => Options::class, 'targetAttribute' => ['option_id' => 'id']],
            [['menu_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => MenuType::class, 'targetAttribute' => ['menu_type_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('cms', 'ID'),
            'option_id' => Yii::t('cms', 'Option ID'),
            'menu_type_id' => Yii::t('cms', 'Menu type ID'),
            'created_at' => Yii::t('cms', 'Created At'),
            'updated_at' => Yii::t('cms', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Collection]].
     *
     * @return ActiveQuery
     */
    public function getOption()
    {
        return $this->hasOne(Options::class, ['id' => 'option_id']);
    }

    /**
     * Gets query for [[Entity]].
     *
     * @return ActiveQuery
     */
    public function getMenuType()
    {
        return $this->hasOne(MenuType::class, ['id' => 'menu_type_id']);
    }
}
