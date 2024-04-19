<?php

use afzalroq\cms\entities\Menu;
use afzalroq\cms\entities\MenuType;
use afzalroq\cms\forms\MenuSearch;
use afzalroq\cms\widgets\menu\CmsNestable;
use slatiusa\nestable\Nestable;
use yii\helpers\Html;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $searchModel MenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $menuType MenuType */

$this->title = Yii::t('cms', 'Menu');
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    ._root_ {
        display: none;
    }

    ._root_ [data-action="collapse"] {
        display: none;
    }
</style>

<div class="menu-index">
    <p>
        <?= Html::a(Yii::t('cms', 'Create'), ['create', 'slug' => $menuType->slug], ['class' => 'btn btn-success']) ?>
    </p>

    <?php
    //echo SortableGridView::widget([
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
    //            'created_at:datetime',
    //        ],
    //    ]);
    // ?>

    <div class="row">
        <div class="col-sm-8">
            <?= CmsNestable::widget([
                'type' => Nestable::TYPE_WITH_HANDLE,
                'query' => Menu::find()->where(['menu_type_id' => $menuType->id]),
                'slug' => $menuType->slug,
                'entity' => CmsNestable::ENTITY_MENU,
                'modelOptions' => [
                    'name' => 'title_' . Yii::$app->params['l'][Yii::$app->language]
                ],
                'pluginEvents' => [
                    'change' => 'function(e) {}',
                ],
                'pluginOptions' => [
                    'maxDepth' => 10,
                ],
            ]); ?>
        </div>
    </div>
</div>
