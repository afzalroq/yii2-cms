<?php

namespace afzalroq\cms\entities;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\helpers\StringHelper;

/**
 * This is the model class for table "cms_menu_type".
 *
 * @property int $id
 * @property string $slug
 * @property string|null $name_0
 * @property string|null $name_1
 * @property string|null $name_2
 * @property string|null $name_3
 * @property string|null $name_4
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Menu[] $cmsMenus
 */
class MenuType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cms_menu_type';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert))
            return false;

        if ($insert)
            return $this->addRootMenu();

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['slug'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['slug', 'name_0', 'name_1', 'name_2', 'name_3', 'name_4'], 'string', 'max' => 255],
            [['slug'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('cms', 'ID'),
            'slug' => Yii::t('cms', 'Slug'),
            'name_0' => Yii::t('cms', 'Name 0'),
            'name_1' => Yii::t('cms', 'Name 1'),
            'name_2' => Yii::t('cms', 'Name 2'),
            'name_3' => Yii::t('cms', 'Name 3'),
            'name_4' => Yii::t('cms', 'Name 4'),
            'created_at' => Yii::t('cms', 'Created At'),
            'updated_at' => Yii::t('cms', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Menus]].
     *
     * @return ActiveQuery
     */
    public function getMenus()
    {
        return $this->hasMany(Menu::class, ['menu_type_id' => 'id']);
    }

    public function add()
    {
        $connection = Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try {
            if ($this->save() || $this->addRootMenu())
                $transaction->rollBack();

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

    public function addRootMenu()
    {
        $menu = new Menu();
        $menu->menu_type_id = $this->id;
        $menu->type = Menu::TYPE_EMPTY;
        $menu->title_0 = StringHelper::mb_ucfirst($this->slug) . ' menu';
        $menu->title_1 = StringHelper::mb_ucfirst($this->slug) . ' menu';
        $menu->title_2 = StringHelper::mb_ucfirst($this->slug) . ' menu';
        return $menu->makeRoot();
    }


}
