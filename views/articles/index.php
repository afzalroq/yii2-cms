<?php

use abdualiym\cms\entities\Articles;
use abdualiym\cms\forms\ArticlesSearch;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel ArticlesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('cms', 'Articles');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="articles-index">

    <p>
        <?= Html::a(Yii::t('cms', 'Create'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'photo',
                'value' => function ($model) {
                    return Html::img($model->getThumbFileUrl('photo', 'sm'));
                },
                'format' => 'raw'
            ],
            'title_0',
            [
                'attribute' => 'category_id',
                'filter' => $searchModel->categoriesList(),
                'value' => function (Articles $model) {
                    return Html::a(Html::encode($model->category->title_0), ['/cms/article-categories/view', 'id' => $model->category_id]);
                },
                'format' => 'raw',
            ],
            'slug',
            'date:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
