<?php

use afzalroq\cms\entities\Menu;
use afzalroq\cms\forms\MenuSearch;
use slatiusa\nestable\Nestable;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel MenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('cms', 'Menu');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-index">
    <p>
        <?= Html::a(Yii::t('cms', 'Create'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <!---->
    <!--    --><?php //= SortableGridView::widget([
    //        'dataProvider' => $dataProvider,
    //        'sortUrl' => Url::to(['sortItem']),
    //        'sortingPromptText' => 'Loading...',
    //        'failText' => 'Fail to sort',
    //        'columns' => [
    //            ['class' => 'yii\grid\SerialColumn'],
    //            [
    //                'attribute' => 'title_0',
    //                'value' => function ($model) {
    //                    return Html::a($model->title_0 . ' <i class="fa fa-chevron-circle-right"></i>', ['menu/view', 'id' => $model->id], ['class' => 'btn btn-default']);
    //                },
    //                'format' => 'html'
    //            ],
    //            [
    //                'attribute' => 'parent_id',
    //                'value' => function (Menu $model) {
    //                    return isset($model->parent) ? $model->parent->title_0 : null;
    //                },
    //                'label' => Yii::t('cms', 'Parent'),
    //            ],
    //            [
    //                'attribute' => 'type',
    //                'value' => function (Menu $model) {
    //                    return $model->typesLists($model->type);
    //                },
    //            ],
    //            [
    //                'attribute' => 'type_helper',
    //                'value' => function (Menu $model) {
    //                    return $model->getTypeValue();
    //                },
    //            ],
    //            'sort',
    //            'created_at:datetime',
    //        ],
    //    ]); ?>

    <div class="row">
        <div class="o col-sm-6 col-sm-offset-3">
            <?= \afzalroq\cms\widgets\menu\CmsNestable::widget([
                'type' => Nestable::TYPE_LIST,
                'query' => Menu::find(),
                'modelOptions' => [
                    'name' => 'title_0'
                ],
                'pluginEvents' => [
                    'change' => 'function(e) {}',
                ],
                'pluginOptions' => [
                    'maxDepth' => 7,
                ],
            ]); ?>
        </div>
    </div>

</div>
