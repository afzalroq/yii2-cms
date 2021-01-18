<?php

use afzalroq\cms\components\FileType;
use afzalroq\cms\entities\Entities;
use afzalroq\cms\widgets\CmsForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model afzalroq\cms\entities\Items */
/* @var $entity Entities */

$this->title = $model->slug;
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms', \yii\helpers\StringHelper::mb_ucfirst($entity->slug)), 'url' => ['index', 'slug' => $entity->slug]];
$this->params['breadcrumbs'][] = $this->title;

[$entity_text_attrs, $entity_file_attrs] = $entity->textAndFileAttrs();

$text_attributes = [];
$file_attributes = [];
$seo_values = [];
$main_photo = [];
$main_attributes = [
    'id',
    'entity_id',
    'slug',
];

if ($model->entity->use_date === Entities::USE_DATE_DATE)
    $main_attributes[] = 'date:date';
if ($model->entity->use_date === Entities::USE_DATE_DATETIME)
    $main_attributes[] = 'date:datetime';


//$cmsForm = new CmsForm((new ActiveForm()), $model, $entity);

foreach ($entity_file_attrs as $attr => $value)
    foreach (Yii::$app->params['cms']['languages2'] as $key => $language)
        if ($entity[$attr])
            $file_attributes[] = [
                'attribute' => $attr . '_' . $key,
                'format' => 'html',
                'value' => function ($model) use ($attr, $key, $entity) {
                    switch (FileType::fileMimeType($entity[$attr . '_mimeType'])) {
                        case FileType::TYPE_FILE:
                            return $model[$attr . '_' . $key];
                        case FileType::TYPE_IMAGE:
                            return Html::img($model->getImageUrl($attr . '_' . $key, $model->entity[$attr . '_dimensionW'], $model->entity[$attr . '_dimensionH']));
                        default:
                            return null;
                    }
                }
            ];

foreach ($entity_text_attrs as $attr => $value)
    foreach (Yii::$app->params['cms']['languages2'] as $key => $language)
        if ($entity[$attr])
            $text_attributes[] = [
                'attribute' => $attr . '_' . $key,
                'label' => $entity[$attr . '_label'] . ' (' . $language . ')',
                'format' => 'html'
            ];

if ($entity->use_seo)
    foreach ($model->seo_values as $key => $value)
        if ($value !== null)
            $seo_values [] = [
                'attribute' => $key,
                'value' => $value,
            ];

if ($entity->use_gallery)
    $main_photo [] = [
        'attribute' => 'main_photo_id',
        'value' => function ($model) {
            if ($model->mainPhoto)
                return Html::a(Html::img($model->mainPhoto->getUploadedFileUrl('file')),
                    $model->mainPhoto->getUploadedFileUrl('file'),
                    ['class' => 'thumbnail', 'target' => '_blank']
                );
        },
        'label' => Yii::t('cms', 'Gallery main Photo'),
        'format' => 'raw'
    ];
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
        'attributes' => $main_attributes
    ]) ?>

    <div class="row">
        <div class="col-sm-12">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => $text_attributes
            ]) ?>
        </div>
        <div class="col-sm-12">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => $file_attributes
            ]) ?>
        </div>
    </div>

    <?php if ($entity->use_seo): ?>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => $seo_values
        ]) ?>
    <?php endif; ?>
    <?php if ($entity->use_views_count): ?>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'views_count'
            ]
        ]) ?>
    <?php endif; ?>
    <?php if ($entity->use_gallery): ?>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => $main_photo
        ]) ?>
    <?php endif; ?>
    <?php if ($entity->use_gallery): ?>
        <div class="box" id="<?= $model->id ?>T">
            <div class="box-body">
                <div class="row">
                    <?php foreach ($model->photos as $photo): ?>
                        <div class="col-md-2 col-xs-3" style="text-align: center">
                            <div class="btn-group">
                                <?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span>', ['move-photo-up', 'id' => $model->id, 'photo_id' => $photo->id, 'slug' => $entity->slug], [
                                    'class' => 'btn btn-default',
                                    'data-method' => 'post',
                                ]) ?>
                                <?= Html::a('<span class="glyphicon glyphicon-remove"></span>', ['delete-photo', 'id' => $model->id, 'photo_id' => $photo->id, 'slug' => $entity->slug], [
                                    'class' => 'btn btn-default',
                                    'data-method' => 'post',
                                    'data-confirm' => 'Remove photo?',
                                ]) ?>
                                <?= Html::a('<span class="glyphicon glyphicon-arrow-right"></span>', ['move-photo-down', 'id' => $model->id, 'photo_id' => $photo->id, 'slug' => $entity->slug], [
                                    'class' => 'btn btn-default',
                                    'data-method' => 'post',
                                ]) ?>
                            </div>
                            <div>
                                <?= Html::a(
                                    Html::img($photo->getUploadedFileUrl('file')),
                                    $photo->getUploadedFileUrl('file'),
                                    ['class' => 'thumbnail', 'target' => '_blank']
                                ) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
