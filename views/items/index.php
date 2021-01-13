<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel afzalroq\cms\entities\ItemsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $entity \afzalroq\cms\entities\Entities */

$slugUrl = '&slug=' . $entity->slug;
$curLang = Yii::$app->params['cms']['languages2'][Yii::$app->params['cms']['languageIds'][Yii::$app->language]];
$this->title = Yii::t('cms', \yii\helpers\StringHelper::mb_ucfirst($entity->slug));
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="items-index">

    <p>
        <?= Html::a(Yii::t('cms', 'Create') . ' ' . $this->title, ['create', 'slug' => $entity->slug], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
//            'entity_id',
            'slug',
            [
                'attribute' => 'text_1_0',
                'label' => $entity->text_1_label . ' (' . $curLang . ')'
            ],
            //'text_1_1:ntext',
            //'text_1_2:ntext',
            //'text_1_3:ntext',
            //'text_1_4:ntext',
            [
                'attribute' => 'text_2_0',
                'label' => $entity->text_2_label . ' (' . $curLang . ')'
            ],
            //'text_2_1:ntext',
            //'text_2_2:ntext',
            //'text_2_3:ntext',
            //'text_2_4:ntext',
            [
                'attribute' => 'text_3_0',
                'label' => $entity->text_3_label . ' (' . $curLang . ')'
            ],
            [
                'attribute' => 'text_4_0',
                'label' => $entity->text_4_label . ' (' . $curLang . ')'
            ],
            //'text_3_1:ntext',
            //'text_3_2:ntext',
            //'text_3_3:ntext',
            //'text_3_4:ntext',
            //'text_4_0:ntext',
            //'text_4_1:ntext',
            //'text_4_2:ntext',
            //'text_4_3:ntext',
            //'text_4_4:ntext',
            //'text_5_0:ntext',
            //'text_5_1:ntext',
            //'text_5_2:ntext',
            //'text_5_3:ntext',
            //'text_5_4:ntext',
            //'text_6_0:ntext',
            //'text_6_1:ntext',
            //'text_6_2:ntext',
            //'text_6_3:ntext',
            //'text_6_4:ntext',
            //'text_7_0:ntext',
            //'text_7_1:ntext',
            //'text_7_2:ntext',
            //'text_7_3:ntext',
            //'text_7_4:ntext',
            [
                'attribute' => 'file_1_0',
                'label' => $entity->file_1_label,
                'format' => 'html',
                'value' => function ($model) {
                    return Html::img($model->getImageUrl('file_1_0', 300, 400));
                }
            ],
            //'file_1_1',
            //'file_1_2',
            //'file_1_3',
            //'file_1_4',
            //'file_2_0',
            //'file_2_1',
            //'file_2_2',
            //'file_2_3',
            //'file_2_4',
            //'file_3_0',
            //'file_3_1',
            //'file_3_2',
            //'file_3_3',
            //'file_3_4',
            //'date',
            //'status',
            'created_at:datetime',
            //'updated_at',

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
