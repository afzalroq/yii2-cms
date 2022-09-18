<?php

use afzalroq\cms\entities\Collections;
use afzalroq\cms\entities\Entities;
use afzalroq\cms\entities\Options;
use yii\helpers\Html;
use yii\widgets\DetailView;


/* @var $this yii\web\View */
/* @var $model Options */
/* @var $collection Collections */

$this->title = $model->{"name_" . Yii::$app->params['l'][Yii::$app->language]};
$this->params['breadcrumbs'][] = ['label' => $collection->{"name_" . Yii::$app->params['l'][Yii::$app->language]}, 'url' => ['index', 'slug' => $collection->slug]];
$this->params['breadcrumbs'][] = $this->title;

$hasTranslatableAttrs = 0;
$collection_text_attrs_translatable = [];
$collectionTextAttrs_0 = [];
$text_attributes = [];


$collectionTextAttrs = $collection->textAttrs();


foreach ($collectionTextAttrs as $key => $attr) {
    if ($attr == Entities::TEXT_DISABLED)
        continue;
    if ($attr < Entities::TEXT_TRANSLATABLE_INPUT_STRING || $attr == Entities::TEXT_COMMON_TEXTAREA || $attr == Entities::TEXT_COMMON_CKEDITOR) {
        $collectionTextAttrs_0 += [
            $key => $attr
        ];
    } else {
        $collection_text_attrs_translatable += [
            $key => $attr
        ];
    }
}

?>
<div class="menu-view">
    <p>
        <?php
        echo Html::a(Yii::t('cms', 'Update'), ['update', 'id' => $model->id, 'slug' => $collection->slug], ['class' => 'btn btn-primary']);
        if ($collection->use_parenting) {
            echo Html::a(Yii::t('cms', 'Add child'), ['add-child', 'root_id' => $model->id, 'slug' => $collection->slug], ['class' => 'btn btn-success']);
        }
        echo Html::a(Yii::t('cms', 'Delete'), ['delete', 'id' => $model->id, 'slug' => $collection->slug], [
            'class' => 'btn btn-danger pull-right',
            'data' => [
                'confirm' => Yii::t('cms', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]);
        ?>
    </p>
    <div class="row">
        <div class="col-sm-6">
            <?php
            $attributes = [];
            if ($model->getCorT('name') !== null && !$model->getCorT('name'))
                $attributes[] = 'name_0';
            if ($model->getCorT('content') !== null && !$model->getCorT('content'))
                $attributes[] = 'content_0:html';
            if ($model->getCorT('file_1') !== null && !$model->getCorT('file_1'))
                $attributes[] = [
                    'attribute' => 'file_1_0',
                    'format' => 'html',
                    'value' => $model->getFileAttrValue('file_1_0'),
                    'label' => $collection->option_file_1_label
                ];

            if ($model->getCorT('file_2') !== null && !$model->getCorT('file_2'))
                $attributes[] = [
                    'attribute' => 'file_2_0',
                    'format' => 'html',
                    'value' => $model->getFileAttrValue('file_2_0'),
                    'label' => $collection->option_file_1_label
                ];
            echo DetailView::widget([
                'model' => $model,
                'attributes' => $attributes
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?php foreach ($collectionTextAttrs_0 as $attr => $value)
                if ($collection[$attr])
                    $text_attributes[] = [
                        'attribute' => $attr . '_' . 0,
                        'label' => $collection[$attr . '_label'],
                        'format' => 'html'
                    ];
            ?>
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => $text_attributes
            ]);
            ?>
            <?php $text_attributes = [] ?>
        </div>
    </div>

    <div class="row" id="translatable">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-body">
                    <ul class="nav nav-tabs" role="tablist">
                        <?php
                        $i = 0;
                        foreach (Yii::$app->params['cms']['languages'] as $key => $language) {
                            $i++;
                            ?>
                            <li role="presentation" <?= $i === 1 ? 'class="active"' : '' ?>>
                                <a href="#<?= $key ?>" aria-controls="<?= $key ?>" role="tab"
                                   data-toggle="tab"><?= $language ?></a>
                            </li>
                        <?php } ?>
                    </ul>
                    <div class="tab-content">
                        <br>
                        <?php
                        $i = 0;
                        foreach (Yii::$app->params['cms']['languages'] as $key => $language) {
                            $i++;
                            ?>
                            <div role="tabpanel" class="tab-pane <?= $i === 1 ? 'active' : '' ?>" id="<?= $key ?>">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <?php
                                        $attributes = [];
                                        if ($model->getCorT('name')) {
                                            $attributes[] = 'name_' . $key;
                                            $hasTranslatableAttrs = 1;
                                        }
                                        if ($model->getCorT('content')) {
                                            $attributes[] = 'content_' . $key . ':html';
                                            $hasTranslatableAttrs = 1;
                                        }
                                        if ($model->getCorT('file_1')) {
                                            $attributes[] = [
                                                'attribute' => 'file_1_' . $key,
                                                'format' => 'html',
                                                'value' => $model->getFileAttrValue('file_1_' . $key)
                                            ];
                                            $hasTranslatableAttrs = 1;
                                        }
                                        if ($model->getCorT('file_2')) {
                                            $attributes[] = [
                                                'attribute' => 'file_2_' . $key,
                                                'format' => 'html',
                                                'value' => $model->getFileAttrValue('file_2_' . $key)
                                            ];
                                            $hasTranslatableAttrs = 1;
                                        }

                                        echo DetailView::widget([
                                            'model' => $model,
                                            'attributes' => $attributes
                                        ]) ?>
                                        <?php foreach ($collection_text_attrs_translatable as $attr => $value)
                                            if ($collection[$attr])
                                                $text_attributes[] = [
                                                    'attribute' => $attr . '_' . $key,
                                                    'label' => $collection[$attr . '_label'] . ' (' . $language . ')',
                                                    'format' => 'html'
                                                ]; ?>
                                        <?= DetailView::widget([
                                            'model' => $model,
                                            'attributes' => $text_attributes
                                        ]);
                                        ?>
                                        <?php $text_attributes = [] ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
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
                                'label' => Yii::t('cms', 'Collection'),
                                'value' => $model->collection->name_0
                            ],
                            // 'sort',
                            [
                                'attribute' => 'created_by',
                                'value' => function ($model) {
                                    return $model->createdBy ? $model->createdBy->username : '';
                                }
                            ],
                            [
                                'attribute' => 'updated_by',
                                'value' => function ($model) {
                                    return $model->updatedBy ? $model->updatedBy->username : '';
                                }
                            ],
                            'created_at:datetime',
                            'updated_at:datetime',
                        ]
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
