<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use afzalroq\cms\entities\Entities;

/* @var $this yii\web\View */
/* @var $model \afzalroq\cms\entities\ItemComments */
/* @var $entity \afzalroq\cms\entities\Entities */

$this->title = \yii\helpers\StringHelper::truncate($item->text_1_0, 40, '...');
$this->params['breadcrumbs'][] = ['label' => $entity->{"name_" . Yii::$app->params['l'][Yii::$app->language]}, 'url' => ['index', 'slug' => $entity->slug]];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/cms/items/view', 'id' => $item->id, 'slug' => $entity->slug]];
$this->title = Yii::t('cms', 'Comments #') . $model->id;
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="faq-view">
    <p>
        <?php if ($model->status == \afzalroq\cms\entities\ItemComments::STATUS_CHECKED) {
            echo Html::a(Yii::t('cms', 'Reply'), ['reply', 'id' => $model->id, 'slug' => $entity->slug], ['class' => 'btn btn-info']);
        }
        ?>
        <?= Html::a(Yii::t('cms', 'Update'), ['update', 'id' => $model->id, 'slug' => $entity->slug,], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('cms', 'Delete'), ['delete', 'id' => $model->id, 'slug' => $entity->slug,], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('cms', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
        <?php if ($model->status == \afzalroq\cms\entities\ItemComments::STATUS_DRAFT): ?>
            <?= Html::a(Yii::t('cms', 'Public'), ['change', 'id' => $model->id, 'slug' => $entity->slug, 'status' => \afzalroq\cms\entities\ItemComments::STATUS_CHECKED], ['class' => 'btn btn-success',]) ?>
            <?php Html::a(Yii::t('cms', 'Remove'), ['change', 'id' => $model->id, 'slug' => $entity->slug, 'status' => \afzalroq\cms\entities\ItemComments::STATUS_DELETED], ['class' => 'btn btn-danger',]) ?>
        <?php elseif ($model->status == \afzalroq\cms\entities\ItemComments::STATUS_CHECKED): ?>
            <?= Html::a(Yii::t('cms', 'Draft'), ['change', 'id' => $model->id, 'slug' => $entity->slug, 'status' => \afzalroq\cms\entities\ItemComments::STATUS_DRAFT], ['class' => 'btn btn-warning',]) ?>
            <?php Html::a(Yii::t('cms', 'Remove'), ['change', 'id' => $model->id, 'slug' => $entity->slug, 'status' => \afzalroq\cms\entities\ItemComments::STATUS_DELETED], ['class' => 'btn btn-danger',]) ?>
        <?php endif; ?>
    </p>
    <div class="box">
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'text',
                        'visible' => $entity->use_comments !== \afzalroq\cms\entities\Entities::COMMENT_OFF,
                    ],
                    [
                        'attribute' => 'vote',
                        'visible' => $entity->use_votes !== \afzalroq\cms\entities\Entities::COMMENT_OFF,
                    ],
                    [
                        'attribute' => 'status',
                        'value' => function ($model) {
                            return \afzalroq\cms\entities\ItemComments::getStatusList()[$model->status];
                        }
                    ],
                    'created_at:datetime',
                    'updated_at:datetime',
                ],
            ]) ?>
            <div class="box">
                <div class="box-header">
                    <?= Html::a(Yii::t('cms', 'Add Comment'), ['item-comments/reply', 'id' => $model->id, 'slug' => $entity->slug], ['class' => 'btn btn-info pull-right']) ?>
                </div>
                <div class="box-body">
                    <?= \yii\grid\GridView::widget([
                        'dataProvider' => $model->getChilds(),
                        'columns' => [
                            [
                                'attribute' => 'text',
                                'visible' => $entity->use_comments != Entities::COMMENT_OFF
                            ],
                            [
                                'attribute' => 'vote',
                                'visible' => $entity->use_votes != Entities::COMMENT_OFF
                            ],
                            [
                                'attribute' => 'user_id',
                                'label' => Yii::t('cms', 'Comment Username'),
                                'value' => function ($model) use ($entity) {
                                    if ($entity->comment_without_login) {
                                        if ($model->user)
                                            return $model->user->username;
                                        else
                                            $model->username;
                                    } else {
                                        return $model->user->username;
                                    }
                                },
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

        </div>
    </div>
</div>

