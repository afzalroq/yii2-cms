<?php

use afzalroq\cms\entities\Collections;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel afzalroq\cms\forms\CollectionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('cms', 'Collections');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="collections-index">

    <p>
        <?= Html::a("<i class='glyphicon glyphicon-home'></i> " . Yii::t('yii', 'Home'), ['/cms/home/index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a(Yii::t('cms', 'Create'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div style="overflow: auto; overflow-y: hidden">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute' => 'slug',
                    'value' => function ($model) {
                        return Html::a($model->slug . ' <i class="fa fa-chevron-circle-right"></i>', ['collections/view', 'id' =>$model->id], ['class' => 'btn btn-default']);
                    },
                    'format' => 'html'
                ],
                'name_0',
                [
                    'attribute' => 'use_in_menu',
                    'value' => function ($model) {
                        return Collections::optionUseInMenuList()[$model->use_in_menu];
                    },
                    'format' =>'boolean'
                ],
                'use_parenting:boolean',
                [
                    'attribute' => 'option_file_1',
                    'value' => function (Collections $model) {
                        return Yii::t('cms', Collections::optionFileList()[$model->option_file_1]) . ' - ' . $model->option_file_1_label;
                    }
                ],
                [
                    'attribute' => 'option_name',
                    'value' => function (Collections $model) {
                        return Yii::t('cms', Collections::optionNameList()[$model->option_name]);
                    }
                ],
                'created_at:datetime',
            ],
        ]) ?>
    </div>
</div>
