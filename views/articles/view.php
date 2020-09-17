<?php

use abdualiym\cms\entities\Articles;
use yii\helpers\Html;
use yii\widgets\DetailView;
use abdualiym\language\Language;

/* @var $this yii\web\View */
/* @var $model Articles */

$this->title = $model->title_0;
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms', 'Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="articles-view">

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
        <div class="col-sm-8">
            <div class="box">
                <div class="box-body">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            'slug',
                            'status:boolean',
                            'date:datetime',
                            'created_at:datetime',
                            'updated_at:datetime',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="box">
                <div class="box-body">
                    <img src="<?= $model->getThumbFileUrl('photo', 'md') ?>">
                </div>
            </div>
        </div>
    </div>
</div>


<div class="box">
    <div class="box-body">
        <ul class="nav nav-tabs" role="tablist">
            <?php foreach (Yii::$app->params['cms']['languages2'] as $key => $language) : ?>
                <li role="presentation" <?= $key == 0 ? 'class="active"' : '' ?>>
                    <a href="#<?= $key ?>" aria-controls="<?= $key ?>" role="tab" data-toggle="tab"><?= $language ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
        <div class="tab-content">
            <br>
            <?php foreach (Yii::$app->params['cms']['languages2'] as $key => $language) : ?>
                <div role="tabpanel" class="tab-pane <?= $key == 0 ? 'active' : '' ?>" id="<?= $key ?>">
                    <h2><?= Language::getAttribute($model, 'title', $key); ?></h2>
                    <div><?= Language::getAttribute($model, 'content', $key); ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
