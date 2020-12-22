<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel abdualiym\cms\forms\EntitiesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('cms', 'Entities');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="entities-index">

    <p>
        <?= Html::a(Yii::t('cms', 'Create Entities'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'slug',
            [
                'attribute' => 'text_1',
                'value' => function ($model) {
                    return \abdualiym\cms\entities\Entities::textList()[$model->text_1];
                }
            ],
            [
                'attribute' => 'text_2',
                'value' => function ($model) {
                    return \abdualiym\cms\entities\Entities::textList()[$model->text_2];
                }
            ],
            [
                'attribute' => 'text_3',
                'value' => function ($model) {
                    return \abdualiym\cms\entities\Entities::textList()[$model->text_3];
                }
            ],
            [
                'attribute' => 'file_1',
                'value' => function ($model) {
                    return \abdualiym\cms\entities\Entities::fileList()[$model->file_1];
                }
            ],
            [
                'attribute' => 'file_2',
                'value' => function ($model) {
                    return \abdualiym\cms\entities\Entities::fileList()[$model->file_2];
                }
            ],
            [
                'attribute' => 'file_3',
                'value' => function ($model) {
                    return \abdualiym\cms\entities\Entities::fileList()[$model->file_3];
                }
            ],
            'created_at:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
