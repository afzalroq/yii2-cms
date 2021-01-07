<?php

use afzalroq\cms\entities\Entities;
use afzalroq\cms\entities\Options;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $collectionProvider ActiveDataProvider */
/* @var $entityProvider ActiveDataProvider */

$this->title = 'My Yii Application';

?>
<div class="site-index">
    <div class="row">
        <div class="col-sm-6">
            <?= ListView::widget([
                'dataProvider' => $collectionProvider,
                'options' => [
                    'tag' => 'ul',
                    'class' => 'list-group'
                ],
                'itemView' => function ($model) {
                    return Html::tag(
                            'span',
                            count($model->options),
                            ['class' => 'badge']
                        ) . Html::a(
                            $model->name_0,
                            Url::to(['/cms/collections/view', 'id' => $model->id])
                        );
                },
                'itemOptions' => [
                    'tag' => 'li',
                    'class' => 'list-group-item'
                ]

            ]) ?>
        </div>
        <div class="col-sm-6">
            <?= ListView::widget([
                'dataProvider' => $entityProvider,
                'options' => [
                    'tag' => 'ul',
                    'class' => 'list-group'
                ],
                'itemView' => function ($model) {
                    return Html::tag(
                            'span',
                            count($model->items),
                            ['class' => 'badge']
                        ) . Html::a(
                            $model->name_0,
                            Url::to(['/cms/entities/view', 'id' => $model->id])
                        );
                },
                'itemOptions' => [
                    'tag' => 'li',
                    'class' => 'list-group-item'
                ]
            ]) ?>
        </div>
    </div>
</div>
