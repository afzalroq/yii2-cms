<?php

use abdualiym\language\Language;
use yii\helpers\Html;
use yii\widgets\DetailView;
use abdualiym\cms\entities\Menu;

/* @var $this yii\web\View */
/* @var $model Menu */

$this->title = $model->title_0;
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms', 'Menu'), 'url' => ['index']];
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
                            [
                                'attribute' => 'parent_id',
                                'value' => function (Menu $model) {
                                    return isset($model->parent) ? $model->parent->title_0 : null;
                                },
                                'label' => Yii::t('cms', 'Parent'),
                            ],
                            [
                                'attribute' => 'type',
                                'value' => function (Menu $model) {
                                    return $model->typesList($model->type);
                                },
                            ],
                            [
                                'attribute' => 'type_helper',
                                'value' => function (Menu $model) {
                                    return $model->getTypeValue();
                                },
                            ],
                       ],
                    ]) ?>
                </div>
                <div class="col-sm-6">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            'sort',
                            'created_at:datetime',
                            'updated_at:datetime',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
