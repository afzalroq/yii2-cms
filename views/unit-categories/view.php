<?php

use afzalroq\cms\entities\unit\Categories;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model Categories */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('unit', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-categories-view">

    <p>
        <?= Html::a(Yii::t('unit', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

        <?= Html::a(Yii::t('unit', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger pull-right',
            'data' => [
                'confirm' => Yii::t('unit', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="box">
        <div class="box-body row">
            <div class="col-sm-6">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'title',
                        'slug',
                        [
                            'attribute' => 'id',
                            'label' => Yii::t('unit', 'View'),
                            'format' => 'raw',
                            'value' => function ($model) {
                                return Html::a(Yii::t('unit', 'Unit for moderator'), ['unit', 'slug' => $model->slug]);
                            }
                        ]
                    ],
                ]) ?>
            </div>
            <div class="col-sm-6">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'created_at:datetime',
                        'updated_at:datetime',
                        [
                            'attribute' => 'id',
                            'label' => Yii::t('unit', 'View'),
                            'format' => 'raw',
                            'value' => function ($model) {
                                return Html::a(Yii::t('unit', 'Unit'), ['unit/index', 'slug' => $model->slug]);
                            }
                        ]
                    ],
                ]) ?>
            </div>
        </div>
    </div>

    <?= $this->render('_units_form', [
        'model' => $model,
        'units' => $units
    ]) ?>

</div>
