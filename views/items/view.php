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
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms', 'Items'), 'url' => ['index', 'slug' => $entity->slug]];
$this->params['breadcrumbs'][] = $this->title;

[$entity_text_attrs, $entity_file_attrs] = $entity->textAFileAttrs();

$text_attributes = [];
$file_attributes = [];
$seo_values = [];
$main_attributes = [
    'id',
    'entity_id',
    'slug',
];

$cmsForm = new CmsForm((new ActiveForm()), $model, $entity);


foreach ($entity_file_attrs as $attr => $value)
    foreach (Yii::$app->params['cms']['languages2'] as $key => $language)
        $file_attributes[] = [
            'attribute' => $attr . '_' . $key,
            'format' => 'html',
            'value' => function ($model) use ($attr, $key, $entity) {
                switch (FileType::fileMimeType($model->entity[$attr . '_mimeType'])) {
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
        $text_attributes[] = [
            'attribute' => $attr . '_' . $key,
            'format' => 'html'
        ];

if ($entity->use_seo)
        foreach ($model->seo_values as $key => $value)
            if ($value !== null)
            $seo_values [] = [
                'attribute' => $key,
                'value' => $value
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

        <div class="col-sm-4">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => $text_attributes
            ]) ?>
        </div>
        <div class="col-sm-8">
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
</div>
