<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('cms', 'Menu Types');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-type-index">
    <p>
        <?= Html::a("<i class='glyphicon glyphicon-home'></i> " . Yii::t('yii', 'Home'), ['/cms/home/index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a(Yii::t('cms', 'Create'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'slug',
                'value' => function ($model) {
                    return Html::a($model->slug . ' <i class="fa fa-chevron-circle-right"></i>', ['menu-type/view', 'id' => $model->id], ['class' => 'btn btn-default']);
                },
                'format' => 'html'
            ],
            'name_0',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]); ?>


</div>
