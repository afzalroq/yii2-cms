<?php

use yii\grid\GridView;
use yii\helpers\Html;
use afzalroq\cms\entities\Collections;

/* @var $this yii\web\View */
/* @var $searchModel afzalroq\cms\forms\CollectionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $collection Collections */

$this->title = Yii::t('cms', 'Options');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="collections-index">

    <p>
        <?= Html::a(Yii::t('cms', 'Create'), ['create', 'slug' => $collection->slug], ['class' => 'btn btn-success']) ?>
    </p>

    <div style="overflow: auto; overflow-y: hidden">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'slug',
                    'value' => function ($model) use ($collection) {
                        return Html::a($model->slug . ' <i class="fa fa-chevron-circle-right"></i>', ['options/view', 'id' => $model->id, 'slug' => $collection->slug], ['class' => 'btn btn-default']);
                    },
                    'format' => 'html'
                ],
                'name_0',
                'content_0',
                'created_at:datetime',
            ],
        ]); ?>
    </div>
</div>
