<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model afzalroq\cms\entities\ItemComments */


$this->title = \yii\helpers\StringHelper::truncate($item->text_1_0, 40, '...');
$this->params['breadcrumbs'][] = ['label' => $entity->{"name_" . Yii::$app->params['l'][Yii::$app->language]}, 'url' => ['/cms/items/index', 'slug' => $entity->slug]];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/cms/items/view', 'id' => $item->id, 'slug' => $entity->slug]];
$this->title = Yii::t('cms', 'Reply');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="entities-create">
    <div class="box box-default">
        <div class="box-header">
            <?= DetailView::widget([
                'model' => $parent,
                'attributes' => [
                    'text:ntext',
                    [
                        'attribute' => 'status',
                        'value' => function($model){
                            return  \afzalroq\cms\entities\ItemComments::getStatusList()[$model->status];
                        }
                    ],
                    'created_at:datetime',
                    'updated_at:datetime',
                ],
            ]) ?>
        </div>
        <div class="box-body">
    <?= $this->render('_form', [
        'model' => $model,
        'entity' => $entity
    ]) ?>
        </div>
    </div>
</div>
