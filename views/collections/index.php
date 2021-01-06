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
        <?= Html::a(Yii::t('cms', 'Create'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div style="overflow: auto; overflow-y: hidden">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'name_0',
                'slug',
                [
                    'attribute' => 'use_in_menu',
                    'value' => function ($model) {
                        return Collections::optionUseInMenuList()[$model->use_in_menu];
                    }
                ],
                'use_parenting',
                [
                    'attribute' => 'option_file_1',
                    'value' => function (Collections $model) {
                        return Yii::t('cms', Collections::optionFileList()[$model->option_file_1]);
                    }
                ],
                'option_file_1_label',
                [
                    'attribute' => 'option_file_2',
                    'value' => function (Collections $model) {
                        return Yii::t('cms', Collections::optionFileList()[$model->option_file_2]);
                    }
                ],
                'option_file_2_label',
                'option_name',
                'option_content',
                'created_at:datetime',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
