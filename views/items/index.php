<?php

use afzalroq\cms\components\FileType;
use yii\grid\GridView;
use yii\helpers\Html;

\afzalroq\cms\assets\GalleryAsset::register($this);

/* @var $this yii\web\View */
/* @var $searchModel afzalroq\cms\forms\ItemsSeab rch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $entity \afzalroq\cms\entities\Entities */

$curLang = Yii::$app->params['l-name'][Yii::$app->language];
$this->title = $entity->{"name_" . Yii::$app->params['l'][Yii::$app->language]};
$this->params['breadcrumbs'][] = $this->title;
$caes = $entity->caes;

$caes = array_filter($entity->caes, function ($item) {
    return $item->show_index == 1;
});
$category_columns = [];
foreach ($caes as $k => $cae) {
    $options = array_filter($cae->collection->options, function ($option) {
        return $option->depth > 0;
    });
    $filter_array = \yii\helpers\ArrayHelper::map($options, function ($item) use ($cae) {
        return $cae->collection->slug . '_' . $item->id;
    }, function ($item) {
        return $item->getName();
    });

    $category_columns[] = [
        'attribute' => "caes_{$k}",
        'label' => $searchModel->getAttributeLabel("caes_{$k}"),
        'format' => 'raw',
        'value' => function ($model) use ($cae) {
            $string = "";
            foreach ($model->o[$cae->collection->slug] as $option) {
                if ($option) {
                    $string .= $option->name . ", ";
                }
            };
            return rtrim($string, ', ');
        },
        'filter' => $filter_array,
    ];
}

$firstKey = array_key_first(Yii::$app->params['cms']['languages']);

$columns = array_merge(
    [
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
            'attribute' => 'text_1_' . $firstKey,
            'value' => function ($model) use ($firstKey, $entity) {
                return Html::a($model->{'text_1_' . $firstKey}, ['/cms/items/view', 'id' => $model->id, 'slug' => $entity->slug]);
            },
            'label' => $entity->text_1_label . ' (' . $curLang . ')',
            'format' => 'html'
        ],
        [
            'attribute' => 'text_2_' . $firstKey,
            'value' => function ($model) use ($entity) {
                if ($entity->text_2 < 30)
                    return $model->text_2_0;
            },
            'label' => $entity->text_2_label . ' (' . $curLang . ')',
            'visible' => !empty($entity->text_2) ? $entity->text_2 > 30 ? false : true : false
        ],
        [
            'attribute' => 'text_3_' . $firstKey,
            'value' => function ($model) use ($entity) {
                if ($entity->text_3 < 30)
                    return $model->text_3_0;
            },
            'label' => $entity->text_3_label . ' (' . $curLang . ')',
            'visible' => !empty($entity->text_3) ? $entity->text_3 > 30 ? false : true : false
        ],
        [
            'attribute' => 'file_1_' . $firstKey,
            'label' => $entity->file_1_label,
            'format' => 'html',
            'value' => function (\afzalroq\cms\entities\Items $model) use ($entity) {
                $w = $w0 = $entity['file_1_dimensionW'];
                $h = $h0 = $entity['file_1_dimensionH'];
                if ($w0 > 64) {
                    $diff = $w0 / 64;
                    $w = 64;
                    $h = $h0 / $diff;
                }
                if ($entity->use_gallery) {
                    if ($model->mainPhoto) {
                        return "<img class='img-circle-prewiew' style='height: ${h}px;  width: ${w}px' src='" . $model->mainPhoto->getPhoto($w0, $h0) . "'/>";
                    } elseif ($model->file_1_0) {
                        return "<img class='img-circle-prewiew' style='height: ${h}px;  width: ${w}px' src='" . $model->getImageUrl('file_1_0', $w0, $h0) . "'/>";
                    }
                } elseif ($model->file_1_0) {
                    return "<img class='img-circle-prewiew' style='height: ${h}px;  width: ${w}px' src='" . $model->getImageUrl('file_1_0', $w0, $h0) . "'/>";
                }
            },
            'visible' => FileType::hasImage($entity)
        ],

        [
            'attribute' => 'views_count',
            'label' => Yii::t('cms', 'Views count'),
            'visible' => $entity->use_views_count
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
            'attribute' => 'date_' . $firstKey,
            'label' => Yii::t('cms', 'Date'),
            'format' => 'html',
            'value' => function (\afzalroq\cms\entities\Items $item) use ($entity) {
                return in_array($entity->use_date, [\afzalroq\cms\entities\Entities::USE_DATE_DATETIME, \afzalroq\cms\entities\Entities::USE_TRANSLATABLE_DATE_DATETIME])
                    ? $item->getDate('d-M, Y H:i')
                    : $item->getDate('d-M, Y');
            },
            'visible' => $entity->use_date ? true : false
        ],


//                        $form->field($cae, 'collection_id')->dropDownList(ArrayHelper::map($unassignedCollections, 'id', 'slug'))

//                        \afzalroq\cms\widgets\CmsForm::OAIList($entity),

        'created_at:datetime',
    ], $category_columns);


?>
<div class="items-index">
    <p>
        <?php if (!$entity->disable_create_and_delete): ?>
            <?= Html::a(Yii::t('cms', 'Create'), ['create', 'slug' => $entity->slug], ['class' => 'btn btn-success']) ?>
        <?php endif; ?>
    </p>

    <div style="overflow: auto; overflow-y: hidden">
        <div class='lightgallery'>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => $columns
            ]) ?>
        </div>
    </div>
</div>
<div id="image-viewer">
    <span class="close">&times;</span>
    <img class="modal-content" id="full-image">
</div>


<?php $this->registerJs(<<<JS
    
     $(".img-circle-prewiew").click(function(){
         $("#full-image").attr("src", $(this).attr("src"));
         $('#image-viewer').show();
     });

$("#image-viewer .close").click(function(){     $('#image-viewer').hide();
});
JS
);
?>
