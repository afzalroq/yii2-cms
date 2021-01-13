<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel afzalroq\cms\forms\EntitiesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('cms', 'Entities');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="entities-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('cms', 'Create ') .Yii::t('cms', 'Entities'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'slug',
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
                }
            ],
            [
                'attribute' => 'text_3',
                'value' => function ($model) {
                    return \afzalroq\cms\entities\Entities::textList()[$model->text_3];
                }
            ],
            //'text_4',
            //'text_5',
            //'text_6',
            //'text_7',
            //'text_label_1',
            //'text_label_2',
            //'text_label_3',
            //'text_label_4',
            //'text_label_5',
            //'text_label_6',
            //'text_label_7',
            [
                'attribute' => 'file_1',
                'value' => function ($model) {
                    return \afzalroq\cms\entities\Entities::fileList()[$model->file_1];
                }
            ],
            [
                'attribute' => 'file_2',
                'value' => function ($model) {
                    return \afzalroq\cms\entities\Entities::fileList()[$model->file_2];
                }
            ],
            [
                'attribute' => 'file_3',
                'value' => function ($model) {
                    return \afzalroq\cms\entities\Entities::fileList()[$model->file_3];
                }
            ],
            //'file_label_1',
            //'file_label_2',
            //'file_label_3',
            //'use_date',
            //'use_status',
            'created_at:datetime',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
