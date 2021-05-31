<?php

use afzalroq\cms\entities\Collections;
use richardfan\sortable\SortableGridView;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel afzalroq\cms\forms\CollectionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $collection Collections */

$this->title = $collection->{"name_" . Yii::$app->params['l'][Yii::$app->language]};
$this->params['breadcrumbs'][] = $this->title;

$curLang = Yii::$app->params['l-name'][Yii::$app->language];
?>
<div class="collections-index">

    <p>
        <?= Html::a(Yii::t('cms', 'Create'), ['create', 'slug' => $collection->slug], ['class' => 'btn btn-success']) ?>
    </p>

    <div style="overflow: auto; overflow-y: hidden">
        <?= SortableGridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'sortUrl' => Url::to(['sortItem']),
            'columns' => [
                [
                    'content' => function(){
                        return "<span class='glyphicon glyphicon-resize-vertical'></span>";
                    },
                    'contentOptions' => ['style'=>'cursor:move;', 'class' => 'moveItem'],
                ],
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'slug',
                    'value' => function ($model) use ($collection) {
                        return Html::a($model->slug . ' <i class="fa fa-chevron-circle-right"></i>', ['options/view', 'id' => $model->id, 'slug' => $collection->slug], ['class' => 'btn btn-default']);
                    },
                    'format' => 'html'
                ],
                'name_0',
                'created_at:datetime',
            ],
        ]); ?>
    </div>
</div>
