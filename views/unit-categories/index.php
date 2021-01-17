<?php

use afzalroq\cms\entities\unit\Categories;
use afzalroq\cms\forms\UnitCategoriesSearch;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel UnitCategoriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('unit', 'Categories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-categories-index">

    <p>
        <?= Html::a(Yii::t('unit', 'Create'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

                        [
                            'attribute' => 'title',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return Html::a($model->title, ['view', 'id' => $model->id], ['class' => 'btn btn-link']);
                            }
                        ],
            [
                'attribute' => 'id',
                'value' => function (Categories $model) {
                    return Html::a(Yii::t('unit','Manage Units'), ['unit/index', 'slug' => $model->slug], ['class' => 'btn btn-default']);
                },
                'label' => Yii::t('unit', 'Unit'),
                'format' => 'raw'
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]); ?>
</div>
