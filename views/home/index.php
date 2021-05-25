<?php

use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $collectionProvider ActiveDataProvider */
/* @var $entityProvider ActiveDataProvider */
/* @var $unitCategoryProvider ActiveDataProvider */
/* @var $menuTypeProvider ActiveDataProvider */

$this->title = Yii::t('cms','CMS Dashboard');

?>
<div class="site-index">
    <div class="row">
        <div class="col-sm-3">
            <div class="row">
                <div class="col-sm-9">
                    <?= Html::a(Yii::t('cms', 'Collections'), Url::to(['/cms/collections/index']), ['class' => 'btn btn-block btn-lg btn-primary']) ?>
                </div>
                <div class="col-sm-3">
                    <?= Html::a('<i class="fa fa-plus"></i>', Url::to(['/cms/collections/create']), ['class' => 'btn btn-block btn-lg btn-primary']) ?>
                </div>
            </div>
            <br>
            <?= ListView::widget([
                'dataProvider' => $collectionProvider,
                'options' => [
                    'tag' => 'ul',
                    'class' => 'list-group'
                ],
                'itemView' => function ($model) {
                    return Html::tag('span', count($model->options), ['class' => 'badge']) . Html::a($model->name_0, Url::to(['/cms/collections/view', 'id' => $model->id]));
                },
                'itemOptions' => [
                    'tag' => 'li',
                    'class' => 'list-group-item'
                ]

            ]) ?>
        </div>
        <div class="col-sm-3">
            <div class="row">
                <div class="col-sm-9">
                <?= Html::a(Yii::t('cms','Entities'), Url::to(['/cms/entities/index']), ['class' => 'btn btn-block btn-lg btn-success']) ?>
                </div>
                <div class="col-sm-3">
                    <?= Html::a('<i class="fa fa-plus"></i>', Url::to(['/cms/entities/create']), ['class' => 'btn btn-block btn-lg btn-success']) ?>
                </div>
            </div>
            <br>
            <?= ListView::widget([
                'dataProvider' => $entityProvider,
                'options' => [
                    'tag' => 'ul',
                    'class' => 'list-group'
                ],
                'itemView' => function ($model) {
                    return Html::tag('span', count($model->items), ['class' => 'badge']) . Html::a($model->name_0, Url::to(['/cms/entities/view', 'id' => $model->id]));
                },
                'itemOptions' => [
                    'tag' => 'li',
                    'class' => 'list-group-item'
                ]
            ]) ?>
        </div>
        <div class="col-sm-3">
            <div class="row">
                <div class="col-sm-9">
                    <?= Html::a(Yii::t('cms','Unit Categories'), Url::to(['/cms/unit-categories/index']), ['class' => 'btn btn-block btn-lg btn-warning']) ?>
                </div>
                <div class="col-sm-3">
                    <?= Html::a('<i class="fa fa-plus"></i>', Url::to(['/cms/unit-categories/create']), ['class' => 'btn btn-block btn-lg btn-warning']) ?>
                </div>
            </div>
            <br>
            <?= ListView::widget([
                'dataProvider' => $unitCategoryProvider,
                'options' => [
                    'tag' => 'ul',
                    'class' => 'list-group'
                ],
                'itemView' => function ($model) {
                    return Html::tag('span') . Html::a($model->title, Url::to(['/cms/unit-categories/view', 'id' => $model->id]));
                },
                'itemOptions' => [
                    'tag' => 'li',
                    'class' => 'list-group-item'
                ]
            ]) ?>
        </div>
        <div class="col-sm-3">
            <div class="row">
                <div class="col-sm-9">
                    <?= Html::a(Yii::t('cms','Menu types'), Url::to(['/cms/menu-type/index']), ['class' => 'btn btn-block btn-lg btn-danger']) ?>
                </div>
                <div class="col-sm-3">
                    <?= Html::a('<i class="fa fa-plus"></i>', Url::to(['/cms/menu-type/create']), ['class' => 'btn btn-block btn-lg btn-danger']) ?>
                </div>
            </div>
            <br>
            <?= ListView::widget([
                'dataProvider' => $menuTypeProvider,
                'options' => [
                    'tag' => 'ul',
                    'class' => 'list-group'
                ],
                'itemView' => function ($model) {
                    return Html::tag('span', count($model->menus), ['class' => 'badge']) . Html::a($model->name_0, Url::to(['/cms/menu-type/view', 'id' => $model->id]));
                },
                'itemOptions' => [
                    'tag' => 'li',
                    'class' => 'list-group-item'
                ]
            ]) ?>
        </div>
    </div>
</div>
