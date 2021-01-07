<?php

use afzalroq\cms\components\FileType;
use afzalroq\cms\entities\CaE;
use afzalroq\cms\entities\Entities;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model abdualiym\cms\entities\Entities */

$this->title = $model->slug;
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms', 'Entities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);

?>
<div class="entities-view">
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
    <div class="row">
        <div class="col-md-4">
            <div class="box">
                <div class="box-body">
					<?= DetailView::widget([
						'model' => $model,
						'attributes' => [
							'id',
							'slug',
							[
								'attribute' => 'use_date',
								'value' => $model->use_date !== null ? Entities::dateList()[$model->use_date] : null
							],
							[
								'attribute' => 'use_status',
								'value' => $model->use_status ? Yii::t('cms', 'Yes') : Yii::t('cms', 'No')
							],
							[
								'attribute' => 'use_in_menu',
								'value' => $model->use_in_menu ? Yii::t('cms', 'Yes') : Yii::t('cms', 'No')
							],
                            [
                                'attribute' => 'use_seo',
                                'value' => $model->use_seo ? Yii::t('cms', 'Yes') : Yii::t('cms', 'No')
                            ],
							'created_at:datetime',
							'updated_at:datetime',
						],
					]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="box">
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-6">
							<?= DetailView::widget([
								'model' => $model,
								'attributes' => [
									[
										'attribute' => 'text_1',
										'value' => function($model) {
											return Entities::textList()[$model->text_1];
										}
									],
									[
										'attribute' => 'text_2',
										'value' => function($model) {
											return Entities::textList()[$model->text_2];
										}
									],
									[
										'attribute' => 'text_3',
										'value' => function($model) {
											return Entities::textList()[$model->text_3];
										}
									],
									[
										'attribute' => 'text_4',
										'value' => function($model) {
											return Entities::textList()[$model->text_4];
										}
									],
									[
										'attribute' => 'text_5',
										'value' => function($model) {
											return Entities::textList()[$model->text_5];
										}
									],
									[
										'attribute' => 'text_6',
										'value' => function($model) {
											return Entities::textList()[$model->text_6];
										}
									],
									[
										'attribute' => 'text_7',
										'value' => function($model) {
											return Entities::textList()[$model->text_7];
										}
									],
								]
							]) ?>
                        </div>
                        <div class="col-sm-6">
							<?= DetailView::widget([
								'model' => $model,
								'attributes' => [
									'text_1_label',
									'text_2_label',
									'text_3_label',
									'text_4_label',
									'text_5_label',
									'text_6_label',
									'text_7_label',
								]
							]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="box">
        <div class="box-body">
            <div class="row">
                <div class="col-sm-4">
					<?= DetailView::widget([
						'model' => $model,
						'attributes' => [
							[
								'attribute' => 'file_1',
								'value' => function(Entities $model) {
									return Yii::t('cms', Entities::fileList()[$model->file_1]);
								}
							],
							'file_1_label',
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
                <div class="col-sm-4">
					<?= DetailView::widget([
						'model' => $model,
						'attributes' => [
							[
								'attribute' => 'file_2',
								'value' => Yii::t('cms', Entities::fileList()[$model->file_2])
							],
							'file_2_label',
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
                <div class="col-sm-4">
					<?= DetailView::widget([
						'model' => $model,
						'attributes' => [
							[
								'attribute' => 'file_3',
								'value' => Yii::t('cms', Entities::fileList()[$model->file_3])
							],
							'file_3_label',
							[
								'attribute' => 'file_3_mimeType',
								'value' => $model->file_3_mimeType !== null ? FileType::MIME_TYPES[$model->file_3_mimeType] : null
							],
							'file_3_dimensionW',
							'file_3_dimensionH',
							[
								'attribute' => 'file_3_maxSize',
								'value' => $model->file_3_maxSize . ' MB'
							],
						],
					]) ?>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <p>
		<?= Html::a(Yii::t('cms', 'Add collection'), ['add-collections', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="box">
        <div class="box-body">
            <div class="row">
				<?php foreach($model->caes as $cae): ?>
                    <div class="col-sm-3">
                        <p>
							<?= Html::a(Yii::t('cms', 'Update'), ['update-collections', 'id' => $model->id, 'caeId' => $cae->id], ['class' => 'btn btn-sm btn-primary']) ?>
							<?= Html::a(Yii::t('cms', 'Delete'), ['delete-collections', 'id' => $model->id, 'caeId' => $cae->id], [
								'class' => 'btn btn-sm btn-danger',
								'data' => [
									'confirm' => Yii::t('cms', 'Are you sure you want to delete this item?'),
									'method' => 'post',
								],
							]) ?>
                        </p>
						<?= DetailView::widget([
							'model' => $cae,
							'attributes' => [
								[
									'attribute' => 'collection_id',
									'label' => 'Collection',
									'value' => $cae->collection->slug
								],
								[
									'attribute' => 'type',
									'value' => CaE::typeList()[$cae->type]
								],
								'sort',
								'size'
							]
						]) ?>
                    </div>
				<?php endforeach; ?>
            </div>
        </div>
    </div>

</div>
