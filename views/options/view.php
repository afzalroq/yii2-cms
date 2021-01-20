<?php

use afzalroq\cms\entities\Collections;
use afzalroq\cms\entities\Options;
use yii\helpers\Html;
use yii\widgets\DetailView;
use afzalroq\cms\components\FileType;


/* @var $this yii\web\View */
/* @var $model Options */
/* @var $collection Collections */

$this->title = $model->slug;
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms', 'Options'), 'url' => ['index', 'slug' => $collection->slug]];
$this->params['breadcrumbs'][] = $this->title;

$hasTranslatableAttrs = 0;


?>
<div class="menu-view">

    <p>
        <?= Html::a(Yii::t('cms', 'Update'), ['update', 'id' => $model->id, 'slug' => $collection->slug], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('cms', 'Delete'), ['delete', 'id' => $model->id, 'slug' => $collection->slug], [
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
                        <?php foreach (Yii::$app->params['cms']['languages2'] as $key => $language) : ?>
                            <li role="presentation" <?= $key == 0 ? 'class="active"' : '' ?>>
                                <a href="#<?= $key ?>" aria-controls="<?= $key ?>" role="tab"
                                   data-toggle="tab"><?= $language ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="tab-content">
                        <br>
                        <?php foreach (Yii::$app->params['cms']['languages2'] as $key => $language) : ?>
                            <div role="tabpanel" class="tab-pane <?= $key == 0 ? 'active' : '' ?>" id="<?= $key ?>">
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
                                'value' => $model->collection->name_0
                            ],
                            [
                                'attribute' => 'parent_id',
                                'label' => 'Parent',
                                'format' => 'html',
                                'value' => $model->getParentValue()
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
                    if ($model->getCorT('name') !== null && !$model->getCorT('name'))
                        $attributes[] = 'name_0';
                    if ($model->getCorT('content') !== null && !$model->getCorT('content'))
                        $attributes[] = 'content_0:html';
                    if ($model->getCorT('file_1') !== null && !$model->getCorT('file_1'))
                        $attributes[] = [
                            'attribute' => 'file_1_0',
                            'format' => 'html',
                            'value' => $model->getFileAttrValue('file_1_0')
                        ];

                    if ($model->getCorT('file_2') !== null && !$model->getCorT('file_2'))
                        $attributes[] = [
                            'attribute' => 'file_2_0',
                            'format' => 'html',
                            'value' => $model->getFileAttrValue('file_2_0')
                        ];
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