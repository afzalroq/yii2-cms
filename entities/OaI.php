<?php

namespace afzalroq\cms\entities;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "cms_options_and_items".
 *
 * @property int         $option_id
 * @property int         $item_id
 *
 * @property Collections $item
 * @property Options     $option
 */
class OaI extends ActiveRecord
{

	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'cms_options_and_items';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['option_id', 'item_id'], 'required'],
			[['option_id', 'item_id'], 'integer'],
			[['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => Collections::class, 'targetAttribute' => ['item_id' => 'id']],
			[['option_id'], 'exist', 'skipOnError' => true, 'targetClass' => Options::class, 'targetAttribute' => ['option_id' => 'id']],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'option_id' => Yii::t('cms', 'Option ID'),
			'item_id' => Yii::t('cms', 'Item ID'),
		];
	}

	/**
	 * Gets query for [[Item]].
	 *
	 * @return ActiveQuery
	 */
	public function getItem()
	{
		return $this->hasOne(Collections::class, ['id' => 'item_id']);
	}

	/**
	 * Gets query for [[Option]].
	 *
	 * @return ActiveQuery
	 */
	public function getOption()
	{
		return $this->hasOne(Options::class, ['id' => 'option_id']);
	}
}
