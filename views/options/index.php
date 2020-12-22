<?php

use yii\grid\GridView;
use yii\helpers\Html;
use afzalroq\cms\entities\Collections;

/* @var $this yii\web\View */
/* @var $searchModel abdualiym\cms\forms\CollectionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $collection Collections */

$slugUrl = '&slug=' . $collection->slug;
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
                'id',
                'name_0',
                'content_0',
                'slug',
                'created_at:datetime',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {update} {delete}',
                    'buttons' => [
                        'view' => function ($url, $model, $key) use ($slugUrl) {
                            return Html::a(Html::tag('span', '', ['class' => "glyphicon glyphicon-eye-open"]), $url . $slugUrl);
                        },
                        'update' => function ($url, $model, $key) use ($slugUrl) {
                            return Html::a(Html::tag('span', '', ['class' => "glyphicon glyphicon-pencil"]), $url . $slugUrl);
                        },
                    ],
                ],
            ],
        ]); ?>
    </div>
</div>
