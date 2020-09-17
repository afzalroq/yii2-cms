<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel ArticleCategoriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('cms', 'Categories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-categories-index">

    <p>
        <?= Html::a(Yii::t('cms', 'Create'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title_0',
            'slug',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
