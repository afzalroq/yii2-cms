<?php

use afzalroq\cms\entities\Collections;
use afzalroq\cms\entities\Options;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model Options */
/* @var $collection Collections */

$this->title = $model->slug;
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms', 'Options'), 'url' => ['index', 'slug' => $collection->slug]];
$this->params['breadcrumbs'][] = $this->title;

//dd([
//	'name' => $model->getCorT('name'),
//	'content' => $model->getCorT('content'),
//	'file_1' => $model->getCorT('file_1'),
//	'file_2' => $model->getCorT('file_2')
//]);

$hasTranslatableAttrs = 0;


?>
<div class="menu-view">

    <p>
		<?= Html::a(Yii::t('cms', 'Update'), ['update', 'id' => $model->id, 'slug' => $collection->slug], ['class' => 'btn btn-primary']) ?>
		<?= Html::a(Yii::t('cms', 'Delete'), ['delete', 'id' => $model->id], [
			'class' => 'btn btn-danger',
			'data' => [
				'confirm' => Yii::t('cms', 'Are you sure you want to delete this item?'),
				'method' => 'post',
			],
		]) ?>
    </p>


    <div class="row" id="translatable">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-body">
                    <ul class="nav nav-tabs" role="tablist">
						<?php foreach(Yii::$app->params['cms']['languages2'] as $key => $language) : ?>
                            <li role="presentation" <?= $key == 0 ? 'class="active"' : '' ?>>
                                <a href="#<?= $key ?>" aria-controls="<?= $key ?>" role="tab"
                                   data-toggle="tab"><?= $language ?></a>
                            </li>
						<?php endforeach; ?>
                    </ul>
                    <div class="tab-content">
                        <br>
						<?php foreach(Yii::$app->params['cms']['languages2'] as $key => $language) : ?>
                            <div role="tabpanel" class="tab-pane <?= $key == 0 ? 'active' : '' ?>" id="<?= $key ?>">
                                <div class="row">
                                    <div class="col-sm-6">
										<?php
										$attributes = [];
										if($model->getCorT('name')) {
											$attributes[] = 'name_' . $key;
											$hasTranslatableAttrs = 1;
										}
										if($model->getCorT('content')) {
											$attributes[] = 'content_' . $key . ':html';
											$hasTranslatableAttrs = 1;
										}
										if($model->getCorT('file_1')) {
											$attributes[] = 'file_1_' . $key;
											$hasTranslatableAttrs = 1;
										}
										if($model->getCorT('file_2')) {
											$attributes[] = 'file_2_' . $key;
											$hasTranslatableAttrs = 1;
										}

										echo DetailView::widget([
											'model' => $model,
											'attributes' => $attributes
										]) ?>
                                    </div>
                                </div>
                            </div>
						<?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="box">
        <div class="box-body">
            <div class="row">
                <div class="col-sm-6">
					<?= DetailView::widget([
						'model' => $model,
						'attributes' => [
							'id',
							'slug',
							[
								'attribute' => 'collection_id',
								'label' => 'Collection',
								'value' => Collections::findOne($model->collection_id)->name_0
							],
							[
								'attribute' => 'parent_id',
								'label' => 'Parent',
								'value' => Options::findOne($model->parent_id) ? Options::findOne($model->parent_id)->name_0 : null
							],
							'sort',
							'created_at:datetime',
							'updated_at:datetime',
						]
					]) ?>
                </div>
                <div class="col-sm-6">
					<?php

					$attributes = [];
					if($model->getCorT('name') !== null && !$model->getCorT('name') )
						$attributes[] = 'name_0';
					if($model->getCorT('content') !== null && !$model->getCorT('content') )
						$attributes[] = 'content_0:html';
					if($model->getCorT('file_1') !== null && !$model->getCorT('file_1') )
						$attributes[] = 'file_1_0';
					if($model->getCorT('file_2') !== null && !$model->getCorT('file_2') )
						$attributes[] = 'file_2_0';

					echo DetailView::widget([
						'model' => $model,
						'attributes' => $attributes
					]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    if (!<?= $hasTranslatableAttrs ?>)
        document.querySelector('#translatable').innerHTML = ''
</script>
