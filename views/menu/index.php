<?php

use abdualiym\cms\forms\MenuSearch;
use yii\grid\GridView;
use yii\helpers\Html;
use abdualiym\cms\entities\Menu;

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

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title_0',
            [
                'attribute' => 'parent_id',
                'value' => function (Menu $model) {
                    return isset($model->parent) ? $model->parent->title_0 : null;
                },
                'label' => Yii::t('cms', 'Parent'),
            ],
            [
                'attribute' => 'type',
                'value' => function (Menu $model) {
                    return $model->typesList($model->type);
                },
            ],
            [
                'attribute' => 'type_helper',
                'value' => function (Menu $model) {
                    return $model->getTypeValue();
                },
            ],
            'sort',
            'created_at:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
