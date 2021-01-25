<?php

use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $collectionProvider ActiveDataProvider */
/* @var $entityProvider ActiveDataProvider */

$this->title = 'CMS Dashboard';

?>
<div class="site-index">
    <div class="row">
        <div class="col-sm-3">


            <p>
                <?= Html::a('Collections', Url::to(['/cms/collections/index']), ['class' => 'btn btn-block btn-lg btn-primary']) ?>
            </p>
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
            <p>
                <?= Html::a('Entities', Url::to(['/cms/entities/index']), ['class' => 'btn btn-block btn-lg btn-success']) ?>
            </p>
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
            <p>
                <?= Html::a('Unit Categories', Url::to(['/cms/unit-categories/index']), ['class' => 'btn btn-block btn-lg btn-warning']) ?>
            </p>
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
            <p>
                <?= Html::a('Menu', Url::to(['/cms/menu/index']), ['class' => 'btn btn-block btn-lg btn-danger']) ?>
            </p>
            <?= ListView::widget([
                'dataProvider' => $menuProvider,
                'options' => [
                    'tag' => 'ul',
                    'class' => 'list-group'
                ],
                'itemView' => function ($model) {
                    return Html::tag('span') . Html::a($model->title_0, Url::to(['/cms/menu/view', 'id' => $model->id]));
                },
                'itemOptions' => [
                    'tag' => 'li',
                    'class' => 'list-group-item'
                ]
            ]) ?>
        </div>
    </div>
</div>
