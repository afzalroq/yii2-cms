<?php

use afzalroq\cms\components\FileType;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel afzalroq\cms\entities\ItemsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $entity \afzalroq\cms\entities\Entities */

$curLang = Yii::$app->params['l-name'][Yii::$app->language];
$this->title = $entity->{"name_" . Yii::$app->params['l'][Yii::$app->language]};
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="items-index">

    <p>
        <?php if (!$entity->disable_create_and_delete): ?>
            <?= Html::a(Yii::t('cms', 'Create'), ['create', 'slug' => $entity->slug], ['class' => 'btn btn-success']) ?>
        <?php endif; ?>
    </p>

    <div style="overflow: auto; overflow-y: hidden">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute' => 'id',
                    'value' => function ($model) use ($entity) {
                        return Html::a($model->id . ' <i class="fa fa-chevron-circle-right"></i>', ['/cms/items/view', 'id' => $model->id, 'slug' => $entity->slug], ['class' => 'btn btn-default'])
                            . Html::a('<i class="fa fa-edit"></i>', ['/cms/items/update', 'id' => $model->id, 'slug' => $entity->slug], ['class' => 'btn btn-default']);
                    },
                    'format' => 'html'
                ],
                [
                    'attribute' => 'text_1_0',
                    'label' => $entity->text_1_label . ' (' . $curLang . ')'
                ],
                [
                    'attribute' => 'text_2_0',
                    'value' => function ($model) use ($entity) {
                        if ($entity->text_2 < 30)
                            return $model->text_2_0;
                    },
                    'label' => $entity->text_2_label . ' (' . $curLang . ')',
                    'visible' => !empty($entity->text_2) ? $entity->text_2 > 30 ? false : true : false
                ],
                [
                    'attribute' => 'text_3_0',
                    'value' => function ($model) use ($entity) {
                        if ($entity->text_3 < 30)
                            return $model->text_3_0;
                    },
                    'label' => $entity->text_3_label . ' (' . $curLang . ')',
                    'visible' => !empty($entity->text_3) ? $entity->text_3 > 30 ? false : true : false
                ],
                [
                    'attribute' => 'file_1_0',
                    'label' => $entity->file_1_label,
                    'format' => 'html',
                    'value' => function (\afzalroq\cms\entities\Items $model) use ($entity) {
                        if ($entity->use_gallery) {
                            return Html::img($model->mainPhoto ? $model->mainPhoto->getPhoto(200, 200) : '');
                        }
                        return Html::img($model->getImageUrl('file_1_0', $entity->file_1_dimensionW, $entity->file_1_dimensionW));
                    },
                    'visible' => $entity->file_1 && FileType::fileMimeType($entity->file_1_mimeType) === FileType::TYPE_IMAGE ? true : false
                ],
//                [
//                    'attribute' => 'use_gallery',
//                    'label' => Yii::t('cms', 'Photo'),
//                    'format' => 'html',
//                    'value' => function (\afzalroq\cms\entities\Items $model) use ($entity) {
//                        return Html::img($model->mainPhoto ? $model->mainPhoto->getPhoto(10, 10) : '');
//                    },
//                    'visible' => $entity->use_gallery ? true : false
//                ],
                [
                    'attribute' => 'date_0',
                    'label' => Yii::t('cms', 'Date'),
                    'format' => 'html',
                    'value' => function (\afzalroq\cms\entities\Items $item) use ($entity) {
                        return in_array($entity->use_date, [\afzalroq\cms\entities\Entities::USE_DATE_DATETIME, \afzalroq\cms\entities\Entities::USE_TRANSLATABLE_DATE_DATETIME])
                            ? $item->getDate('d-M, Y H:i')
                            : $item->getDate('d-M, Y');
                    },
                    'visible' => $entity->use_date ? true : false
                ],
                'created_at:datetime',
            ],
        ]) ?>
    </div>
</div>
