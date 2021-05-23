<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel afzalroq\cms\forms\EntitiesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('cms', 'Entities');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="entities-index">

    <p>
        <?= Html::a("<i class='glyphicon glyphicon-home'></i> " . Yii::t('yii', 'Home'), ['/cms/home/index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a(Yii::t('cms', 'Create'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'slug',
                'value' => function ($model) {
                    return Html::a($model->slug . ' <i class="fa fa-chevron-circle-right"></i>', ['entities/view', 'id' => $model->id], ['class' => 'btn btn-default']);
                },
                'format' => 'html'
            ],
            [
                'attribute' => 'text_1',
                'value' => function ($model) {
                    return \afzalroq\cms\entities\Entities::textList()[$model->text_1];
                }
            ],
            [
                'attribute' => 'text_2',
                'value' => function ($model) {
                    return \afzalroq\cms\entities\Entities::textList()[$model->text_2];
                },
                'visible' => $searchModel->text_2 ? true : false
            ],
            [
                'attribute' => 'text_3',
                'value' => function ($model) {
                    return \afzalroq\cms\entities\Entities::textList()[$model->text_3];
                },
                'visible' => $searchModel->text_3 ? true : false
            ],
            [
                'attribute' => 'file_1',
                'value' => function ($model) {
                    return \afzalroq\cms\entities\Entities::fileList()[$model->file_1];
                },
                'visible' => $searchModel->file_1 ? true : false
            ],
            [
                'attribute' => 'file_2',
                'value' => function ($model) {
                    return \afzalroq\cms\entities\Entities::fileList()[$model->file_2];
                },
                'visible' => $searchModel->file_2 ? true : false
            ],
            [
                'attribute' => 'file_3',
                'value' => function ($model) {
                    return \afzalroq\cms\entities\Entities::fileList()[$model->file_3];
                },
                'visible' => $searchModel->file_3 ? true : false
            ],
            'created_at:datetime',
        ],
    ]) ?>
</div>
