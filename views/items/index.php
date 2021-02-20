<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel afzalroq\cms\entities\ItemsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $entity \afzalroq\cms\entities\Entities */

$curLang = Yii::$app->params['cms']['languages'][Yii::$app->params['cms']['languageIds'][Yii::$app->language]];
$this->title = Yii::t('cms', \yii\helpers\StringHelper::mb_ucfirst($entity->slug));
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="items-index">

    <p>
        <?= Html::a(Yii::t('cms', 'Create'), ['create', 'slug' => $entity->slug], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'slug',
                'value' => function ($model) use ($entity) {
                    return Html::a($model->slug . ' <i class="fa fa-chevron-circle-right"></i>', ['items/view', 'id' => $model->id, 'slug' => $entity->slug], ['class' => 'btn btn-default']);
                },
                'format' => 'html'
            ],
            [
                'attribute' => 'text_1_0',
                'label' => $entity->text_1_label . ' (' . $curLang . ')'
            ],
            [
                'attribute' => 'text_2_0',
                'label' => $entity->text_2_label . ' (' . $curLang . ')'
            ],
            [
                'attribute' => 'text_3_0',
                'label' => $entity->text_3_label . ' (' . $curLang . ')'
            ],
            [
                'attribute' => 'text_4_0',
                'label' => $entity->text_4_label . ' (' . $curLang . ')'
            ],
            [
                'attribute' => 'file_1_0',
                'label' => $entity->file_1_label,
                'format' => 'html',
                'value' => function (\afzalroq\cms\entities\Items $model) use ($entity) {
                    return Html::img($model->getImageUrl('file_1_0', $entity->file_1_dimensionW, $entity->file_1_dimensionW));
                }
            ],
            'created_at:datetime',
        ],
    ]); ?>


</div>
