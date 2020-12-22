<?php

use afzalroq\cms\components\FileType;
use afzalroq\cms\entities\Entities;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model abdualiym\cms\entities\Items */
/* @var $entity Entities */

$this->title = $model->slug;
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms', 'Items'), 'url' => ['index', 'slug' => $entity->slug]];
$this->params['breadcrumbs'][] = $this->title;

[$entity_text_attrs, $entity_file_attrs] = $entity->textAFileAttrs();

$attributes = [
	'id',
	'entity_id',
	'slug',
];

foreach(Yii::$app->params['cms']['languages2'] as $key => $language) {
	foreach($entity_file_attrs as $attr => $value) {
		$attributes[] = [
			'attribute' => $attr . '_' . $key,
			'format' => 'html',
			'value' => function($model) use ($attr, $key) {
				switch(FileType::fileMimeType($model->entity[$attr . '_mimeType'])) {
					case FileType::TYPE_FILE:
						return $model[$attr . '_' . $key];
					case FileType::TYPE_IMAGE:
						return Html::img($model->getImageUrl($attr . '_' . $key, $model->entity[$attr . '_dimensionW'], $model->entity[$attr . '_dimensionH']));
					default:
						return null;
				}
			}
		];
	}

	foreach($entity_text_attrs as $attr => $value) {
		$attributes[] = $attr . '_' . $key;
	}
}
?>

<div class="items-view">
    <p>
		<?= Html::a(Yii::t('cms', 'Update'), ['update', 'id' => $model->id, 'slug' => $entity->slug], ['class' => 'btn btn-primary']) ?>
		<?= Html::a(Yii::t('cms', 'Delete'), ['delete', 'id' => $model->id], [
			'class' => 'btn btn-danger',
			'data' => [
				'confirm' => Yii::t('cms', 'Are you sure you want to delete this item?'),
				'method' => 'post',
			],
		]) ?>
    </p>

	<?= DetailView::widget([
		'model' => $model,
		'attributes' => $attributes
	]) ?>

</div>
