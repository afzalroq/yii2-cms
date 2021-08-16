<?php

use afzalroq\cms\components\FileType;
use afzalroq\cms\entities\Entities;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model afzalroq\cms\entities\Items */
/* @var $entity Entities */
/* @var $commentsDataProvider \afzalroq\cms\entities\ItemComments */

$this->title = \yii\helpers\StringHelper::truncate($model->text_1_0, 40, '...');
$this->params['breadcrumbs'][] = ['label' => $entity->{"name_" . Yii::$app->params['l'][Yii::$app->language]}, 'url' => ['index', 'slug' => $entity->slug]];
$this->params['breadcrumbs'][] = $this->title;

[$entity_text_attrs, $entity_file_attrs, $seo_attrs] = $entity->textAndFileAttrs();

$entity_text_attrs_translatable = [];
$entity_text_attrs_0 = [];

$file_lang_0 = [];
$file_translatable = [];

$seo_translatable = [];
$seo_0 = [];

$text_attributes = [];
$file_attributes = [];
$seo_values = [];
$main_photo = [];
$data_translatable = [];

foreach ($entity_text_attrs as $key => $attr) {
    if ($attr == Entities::TEXT_DISABLED)
        continue;
    if ($attr < Entities::TEXT_TRANSLATABLE_INPUT_STRING || $attr == Entities::TEXT_COMMON_TEXTAREA || $attr == Entities::TEXT_COMMON_CKEDITOR) {
        $entity_text_attrs_0 += [
            $key => $attr
        ];
    } else {
        $entity_text_attrs_translatable += [
            $key => $attr
        ];
    }
}

foreach ($entity_file_attrs as $key => $attr) {
    if ($attr === Entities::FILE_DISABLED)
        continue;
    if ($attr === Entities::FILE_TRANSLATABLE) {
        $file_translatable += [
            $key => $attr
        ];
    } else {
        $file_lang_0 += [
            $key => $attr
        ];
    }

}


$main_attributes = [
    'slug',
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
];

if ($entity->use_views_count) {
    $main_attributes = array_merge($main_attributes, ['views_count']);
}

if ($model->entity->use_date === Entities::USE_DATE_DATE)
    $main_attributes[] = 'date_0:date';
if ($model->entity->use_date === Entities::USE_DATE_DATETIME)
    $main_attributes[] = 'date_0:datetime';


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
<style>
    body img {
        max-width: 100%;
        height: auto;
    }
</style>
<div class="items-view">
    <p>
        <?= Html::a(Yii::t('cms', 'Update'), ['update', 'id' => $model->id, 'slug' => $entity->slug], ['class' => 'btn btn-primary']) ?>
        <?php if (!$entity->disable_create_and_delete) : ?>
            <?= Html::a(Yii::t('cms', 'Delete'), ['delete', 'id' => $model->id, 'slug' => $entity->slug], [
                'class' => 'btn btn-danger pull-right',
                'data' => [
                    'confirm' => Yii::t('cms', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif; ?>
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => $main_attributes
    ]) ?>

    <div class="row">
        <div class="col-sm-12">
            <?php foreach ($entity_text_attrs_0 as $attr => $value)
                if ($entity[$attr])
                    $text_attributes[] = [
                        'attribute' => $attr . '_' . 0,
                        'label' => $entity[$attr . '_label'],
                        'format' => 'html'
                    ]; ?>
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => $text_attributes
            ]) ?>
            <?php $text_attributes = [] ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <?php
            foreach ($file_lang_0 as $attr => $value)
                if ($entity[$attr]) {
                    $file_attributes[] = [
                        'attribute' => $attr . '_' . 0,
                        'format' => 'html',
                        'value' => function ($model) use ($attr, $entity) {
                            switch (FileType::fileMimeType($entity[$attr . '_mimeType'])) {
                                case FileType::TYPE_FILE:
                                    return $model[$attr . '_' . 0];
                                case FileType::TYPE_IMAGE:
                                    return Html::img($model->getImageUrl($attr . '_' . 0, $model->entity[$attr . '_dimensionW'], $model->entity[$attr . '_dimensionH']));
                                default:
                                    return null;
                            }
                        },
                        'label' => $model->entity[$attr . '_label']
                    ];
                    if ($model->isAttrCommon($attr)) break;
                }
            ?>
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => $file_attributes
            ]) ?>
            <?php $file_attributes = [] ?>
        </div>
    </div>

    <?php if ($entity->use_seo && $entity->use_seo == Entities::SEO_COMMON): ?>
        <?php
        foreach ($seo_attrs as $i => $value)
            $seo_values [] = [
                'attribute' => $value . '_' . 0,
                'value' => $model->seo_values[$value . '_' . 0],
            ];

        echo DetailView::widget([
            'model' => $model,
            'attributes' => $seo_values
        ]);

        $seo_values = [];
        ?>
    <?php endif; ?>
    <?php if ($entity->use_seo == Entities::SEO_TRANSLATABLE || !empty($entity_text_attrs_translatable) || !empty($file_translatable)): ?>
        <div class="row" id="translatable">
            <div class="col-md-12">
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
                                    <?php
                                    if ($model->entity->use_date === Entities::USE_TRANSLATABLE_DATE_DATE) {
                                        $data_translatable[] = 'date_' . $key . ':date';

                                        echo DetailView::widget([
                                            'model' => $model,
                                            'attributes' => $data_translatable
                                        ]);

                                        $data_translatable = [];
                                    }
                                    if ($model->entity->use_date === Entities::USE_TRANSLATABLE_DATE_DATETIME) {
                                        $data_translatable[] = 'date_' . $key . ':datetime';

                                        echo DetailView::widget([
                                            'model' => $model,
                                            'attributes' => $data_translatable
                                        ]);

                                        $data_translatable = [];
                                    }
                                    ?>
                                    <?php foreach ($entity_text_attrs_translatable as $attr => $value)
                                        if ($entity[$attr])
                                            $text_attributes[] = [
                                                'attribute' => $attr . '_' . $key,
                                                'label' => $entity[$attr . '_label'] . ' (' . $language . ')',
                                                'format' => 'html'
                                            ]; ?>
                                    <?= DetailView::widget([
                                        'model' => $model,
                                        'attributes' => $text_attributes
                                    ]) ?>
                                    <?php $text_attributes = [] ?>

                                    <?php
                                    foreach ($file_translatable as $attr => $value)
                                        if ($entity[$attr]) {
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
                                                },
                                                'label' => $model->entity[$attr . '_label']
                                            ];
                                            if ($model->isAttrCommon($attr)) break;
                                        }
                                    ?>
                                    <?= DetailView::widget([
                                        'model' => $model,
                                        'attributes' => $file_attributes
                                    ]) ?>
                                    <?php $file_attributes = [] ?>

                                    <?php
                                    if ($entity->use_seo == Entities::SEO_TRANSLATABLE) {
                                        foreach ($seo_attrs as $i => $value)
                                            $seo_values [] = [
                                                'attribute' => $value . '_' . $key,
                                                'value' => $model->seo_values[$value . '_' . $key],
                                            ];

                                        echo DetailView::widget([
                                            'model' => $model,
                                            'attributes' => $seo_values
                                        ]);

                                        $seo_values = [];
                                    }
                                    ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if ($entity->use_gallery): ?>
        <div class="box" id="<?= $model->id ?>">
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
    <?php if ($entity->use_gallery): ?>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                [
                    'attribute' => 'main_photo_id',
                    'format' => 'raw',
                    'value' => function (\afzalroq\cms\entities\Items $model) {
                        return Html::img($model->getGalleryPhoto(480, 360, 'scaleResize', 'transparent', 'center', 'center'), ['style' => 'width: 300px;']);
                    },
                    'label' => Yii::t('cms', 'Gallery main Photo')
                ]
            ]
        ]) ?>
    <?php endif; ?>

    <?php if ($entity->use_comments != Entities::COMMENT_OFF || $entity->use_votes != Entities::COMMENT_OFF): ?>
        <div class="box">
            <div class="box-header">
                <?= Html::a(Yii::t('cms', 'Refresh'), ['items/refresh-comment-stats', 'id' => $model->id, 'slug' => $entity->slug], [
                    'class' => 'btn btn-info pull-right',
                    'data' => [
                        'confirm' => Yii::t('cms', 'Are you sure you want to refresh the stats?'),
                        'method' => 'post',
                    ],
                ]) ?>
            </div>
            <div class="box-body">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'comments_count',
                        'votes_count',
                        'avarage_voting',
                    ]
                ]) ?>
            </div>
        </div>

        <br>
        <div class="box">
            <div class="box-header">
                <h4><?= Yii::t('cms', 'Comments Section') ?></h4>
                <?= Html::a(Yii::t('cms', 'Add Comment'), ['item-comments/add', 'item_id' => $model->id, 'slug' => $entity->slug], ['class' => 'btn btn-info pull-right']) ?>
            </div>
            <div class="box-body">
                <?= \yii\grid\GridView::widget([
                    'dataProvider' => $commentsDataProvider,
                    'columns' => [
                        [
                            'attribute' => 'user_id',
                            'label' => Yii::t('cms', 'Comment Username'),
                            'value' => function ($model) use ($entity) {
                                return $model->username;
                            },
                        ],
                        [
                            'attribute' => 'text',
                            'visible' => $entity->use_comments != Entities::COMMENT_OFF
                        ],
                        [
                            'attribute' => 'vote',
                            'visible' => $entity->use_votes != Entities::COMMENT_OFF
                        ],

                        [
                            'attribute' => 'status',
                            'value' => function ($model) {
                                return \afzalroq\cms\entities\ItemComments::getStatusList()[$model->status];
                            }
                        ],
                        'created_at:datetime',
                        'updated_at:datetime',

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{view}  {reply} {delete}',
                            'buttons' => [
                                'reply' => function ($url, $model) use ($entity) {
                                    return Html::a('<i class="fa fa-reply"></i>', ['/cms/item-comments/reply', 'id' => $model->id, 'slug' => $entity->slug], []);
                                },
                                'view' => function ($url, $model) use ($entity) {
                                    return Html::a('<i class="fa fa-eye"></i>', ['/cms/item-comments/view', 'id' => $model->id, 'slug' => $entity->slug]);
                                },
                                'delete' => function ($url, $model) use ($entity) {
                                    return Html::a('<i class="fa fa-trash"></i>', ['/cms/item-comments/delete', 'id' => $model->id, 'slug' => $entity->slug], [
                                        'data' => [
                                            'confirm' => Yii::t('cms', 'Are you sure you want to delete this item?'),
                                            'method' => 'post',
                                        ],
                                    ]);
                                }
                            ]
                        ]
                    ]
                ])
                ?>
            </div>
        </div>
    <?php endif ?>
</div>

