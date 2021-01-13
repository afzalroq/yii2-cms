<?php

use afzalroq\cms\entities\unit\Unit;
use afzalroq\cms\helpers\UnitType;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model Unit */
/* @var $category \afzalroq\unit\entities\Categories */

$this->title = $model->label;
$this->params['breadcrumbs'][] = ['label' => Yii::t('unit','Unit'), 'url' => ['index', 'slug' => $category->slug]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="articles-view">

    <p>
        <?= Html::a(Yii::t('unit', 'Update'), ['update', 'id' => $model->id, 'slug' => $category->slug], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('unit', 'Delete'), ['delete', 'id' => $model->id, 'slug' => $category->slug], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('unit', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="row">
        <div class="col-sm-6">
            <div class="box">
                <div class="box-body">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'label',
                            'slug',
                            [
                                'attribute' => 'type',
                                'value' => function ($model) {
                                    return UnitType::name($model->type);
                                }
                            ],
                            'sort',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="box">
                <div class="box-body">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'size',
                            'id',
                            'created_at:datetime',
                            'updated_at:datetime',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

</div>
