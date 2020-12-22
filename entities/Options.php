<?php

namespace abdualiym\cms\entities;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yiidreamteam\upload\FileUploadBehavior;

/**
 * This is the model class for table "cms_options".
 *
 * @property int         $id
 * @property int         $collection_id
 * @property int|null    $parent_id
 * @property string      $slug
 * @property string|null $name_0
 * @property string|null $name_1
 * @property string|null $name_2
 * @property string|null $name_3
 * @property string|null $name_4
 * @property string|null $content_0
 * @property string|null $content_1
 * @property string|null $content_2
 * @property string|null $content_3
 * @property string|null $content_4
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
 * @property int         $sort
 * @property int         $created_at
 * @property int         $updated_at
 *
 * @property Collections $collection
 */
class Options extends ActiveRecord
{

	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'cms_options';
	}

	public function getCorT($justAttr)
	{
		if(!$this->collection)
			return null;

		$attrValue = $this->collection['option_' . $justAttr];
		switch($justAttr) {
			case 'name':
				if($attrValue === Collections::OPTION_NAME_COMMON)
					return false;
				elseif($attrValue === Collections::OPTION_NAME_TRANSLATABLE)
					return true;
				break;
			case 'content':
				if($attrValue === Collections::OPTION_CONTENT_COMMON_TEXTAREA
					|| $attrValue === Collections::OPTION_CONTENT_COMMON_CKEDITOR)
					return false;
				elseif($attrValue !== Collections::OPTION_CONTENT_DISABLED)
					return true;
				break;
			case 'file_1':
			case 'file_2':
				if($attrValue === Collections::OPTION_FILE_COMMON)
					return false;
				elseif($attrValue === Collections::OPTION_FILE_TRANSLATABLE)
					return true;
				break;
			default:
				return null;
		}

		return null;
//		$r = new \ReflectionClass(Collections::class);
//		if($r->getConstant('OPTION_' . mb_strtoupper($justAttr) . '_DISABLED'))
//			dd(mb_strtoupper($justAttr));
//
//		dd($r->getConstant('OPTION_NAME_COMMON'));
	}

	public function getImageUrl($attr, $width = null, $height = null, $resizeType = 'resize')
	{
		return Image::get($this, $attr, $width, $height, $resizeType);
	}

	public function behaviors()
	{
		return [
			TimestampBehavior::class,
			$this->getFileUploadBehaviorConfig('file_1_0'),
			$this->getFileUploadBehaviorConfig('file_1_1'),
			$this->getFileUploadBehaviorConfig('file_1_2'),
			$this->getFileUploadBehaviorConfig('file_1_3'),
			$this->getFileUploadBehaviorConfig('file_1_4'),
			$this->getFileUploadBehaviorConfig('file_2_0'),
			$this->getFileUploadBehaviorConfig('file_2_1'),
			$this->getFileUploadBehaviorConfig('file_2_2'),
			$this->getFileUploadBehaviorConfig('file_2_3'),
			$this->getFileUploadBehaviorConfig('file_2_4')
		];
	}

	private function getFileUploadBehaviorConfig($attribute)
	{
		$module = Yii::$app->getModule('slider');

		return [
			'class' => FileUploadBehavior::class,
			'attribute' => $attribute,
			'filePath' => $module->storageRoot . '/data/options/[[attribute_id]]/[[filename]].[[extension]]',
			'fileUrl' => $module->storageHost . '/data/options/[[attribute_id]]/[[filename]].[[extension]]',
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['file_1_0', 'file_1_1', 'file_1_2', 'file_1_3', 'file_1_4', 'file_2_0', 'file_2_1', 'file_2_2', 'file_2_3', 'file_2_4'], 'file'],
			[['collection_id', 'slug'], 'required'],
			[['collection_id', 'parent_id', 'sort', 'created_at', 'updated_at'], 'integer'],
			[['content_0', 'content_1', 'content_2', 'content_3', 'content_4'], 'string'],
			[['slug', 'name_0', 'name_1', 'name_2', 'name_3', 'name_4',], 'string', 'max' => 255],
			[['slug'], 'unique'],
			[['collection_id'], 'exist', 'skipOnError' => true, 'targetClass' => Collections::class, 'targetAttribute' => ['collection_id' => 'id']],
		];
	}

	public function attributeLabels()
	{
		$language0 = isset(Yii::$app->params['cms']['languages2'][0]) ? Yii::$app->params['cms']['languages2'][0] : '';
		$language1 = isset(Yii::$app->params['cms']['languages2'][1]) ? Yii::$app->params['cms']['languages2'][1] : '';
		$language2 = isset(Yii::$app->params['cms']['languages2'][2]) ? Yii::$app->params['cms']['languages2'][2] : '';
		$language3 = isset(Yii::$app->params['cms']['languages2'][3]) ? Yii::$app->params['cms']['languages2'][3] : '';
		$language4 = isset(Yii::$app->params['cms']['languages2'][4]) ? Yii::$app->params['cms']['languages2'][4] : '';

		return [
			'id' => Yii::t('cms', 'ID'),
			'slug' => Yii::t('cms', 'Slug'),
			'name_0' => Yii::t('cms', 'Name') . '(' . $language0 . ')',
			'name_1' => Yii::t('cms', 'Name') . '(' . $language1 . ')',
			'name_2' => Yii::t('cms', 'Name') . '(' . $language2 . ')',
			'name_3' => Yii::t('cms', 'Name') . '(' . $language3 . ')',
			'name_4' => Yii::t('cms', 'Name') . '(' . $language4 . ')',
			'content_0' => Yii::t('cms', 'Content') . '(' . $language0 . ')',
			'content_1' => Yii::t('cms', 'Content') . '(' . $language1 . ')',
			'content_2' => Yii::t('cms', 'Content') . '(' . $language2 . ')',
			'content_3' => Yii::t('cms', 'Content') . '(' . $language3 . ')',
			'content_4' => Yii::t('cms', 'Content') . '(' . $language4 . ')',
			'file_1_0' => Yii::t('cms', 'File') . '1(' . $language0 . ')',
			'file_1_1' => Yii::t('cms', 'File') . '1(' . $language1 . ')',
			'file_1_2' => Yii::t('cms', 'File') . '1(' . $language2 . ')',
			'file_1_3' => Yii::t('cms', 'File') . '1(' . $language3 . ')',
			'file_1_4' => Yii::t('cms', 'File') . '1(' . $language3 . ')',
			'file_2_0' => Yii::t('cms', 'File') . '2(' . $language0 . ')',
			'file_2_1' => Yii::t('cms', 'File') . '2(' . $language1 . ')',
			'file_2_2' => Yii::t('cms', 'File') . '2(' . $language2 . ')',
			'file_2_3' => Yii::t('cms', 'File') . '2(' . $language3 . ')',
			'file_2_4' => Yii::t('cms', 'File') . '2(' . $language4 . ')',
			'sort' => Yii::t('cms', 'Sort'),
			'created_at' => Yii::t('cms', 'Created At'),
			'updated_at' => Yii::t('cms', 'Updated At'),
		];
	}

	/**
	 * Gets query for [[Collections]].
	 *
	 * @return ActiveQuery
	 */
	public function getCollection()
	{
		return $this->hasOne(Collections::class, ['id' => 'collection_id']);
	}

}
