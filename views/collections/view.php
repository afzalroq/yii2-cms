<?php

use afzalroq\cms\components\FileType;
use afzalroq\cms\entities\Collections;
use afzalroq\cms\components\Language;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model Collections */

$this->title = $model->slug;
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms', 'Collection'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="menu-view">

    <p>
		<?= Html::a(Yii::t('cms', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
		<?= Html::a(Yii::t('cms', 'Delete'), ['delete', 'id' => $model->id], [
			'class' => 'btn btn-danger',
			'data' => [
				'confirm' => Yii::t('cms', 'Are you sure you want to delete this item?'),
				'method' => 'post',
			],
		]) ?>
    </p>


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
                        <h2><?= Language::getAttribute($model, 'name', $key); ?></h2>
                    </div>
				<?php endforeach; ?>
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
							'created_at:datetime',
							'updated_at:datetime',
						],
					]) ?>
                </div>
                <div class="col-sm-6">
					<?= DetailView::widget([
						'model' => $model,
						'attributes' => [
							[
								'attribute' => 'use_in_menu',
								'value' => Collections::optionUseInMenuList()[$model->use_in_menu]
							],
							[
								'attribute' => 'use_parenting',
								'value' => $model->use_parenting ? Yii::t('cms', 'Yes') : Yii::t('cms', 'No')
							],
							[
								'attribute' => 'option_name',
								'value' => function(Collections $model) {
									return Yii::t('cms', Collections::optionNameList()[$model->option_name]);
								}
							],
							[
								'attribute' => 'option_content',
								'value' => function(Collections $model) {
									return Yii::t('cms', Collections::optionContentList()[$model->option_content]);
								}
							],
						],
					]) ?>
                </div>
                <div class="col-sm-6">
					<?= DetailView::widget([
						'model' => $model,
						'attributes' => [
							[
								'attribute' => 'option_file_1',
								'value' => function(Collections $model) {
									return Yii::t('cms', Collections::optionFileList()[$model->option_file_1]);
								}
							],
							'option_file_1_label',
							[
								'attribute' => 'file_1_mimeType',
								'value' => $model->file_1_mimeType !== null ? FileType::MIME_TYPES[$model->file_1_mimeType] : null
							],
							'file_1_dimensionW',
							'file_1_dimensionH',
							[
								'attribute' => 'file_1_maxSize',
								'value' => $model->file_1_maxSize . ' MB'
							],
						],
					]) ?>
                </div>
                <div class="col-sm-6">
					<?= DetailView::widget([
						'model' => $model,
						'attributes' => [
							[
								'attribute' => 'option_file_2',
								'value' => Yii::t('cms', Collections::optionFileList()[$model->option_file_2])
							],
							'option_file_2_label',
							[
								'attribute' => 'file_2_mimeType',
								'value' => $model->file_2_mimeType !== null ? FileType::MIME_TYPES[$model->file_2_mimeType] : null
							],
							'file_2_dimensionW',
							'file_2_dimensionH',
							[
								'attribute' => 'file_2_maxSize',
								'value' => $model->file_2_maxSize . ' MB'
							],
						],
					]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
