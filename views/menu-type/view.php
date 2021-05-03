<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model afzalroq\cms\entities\MenuType */

$this->title = $model->slug;
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms', 'Menu Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="menu-type-view">

    <p>
        <?= Html::a(Yii::t('cms', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('cms', 'View menus') . " <i class='fa fa-chevron-circle-right'></i>", ['/cms/menu/index', 'slug' => $model->slug], ['class' => 'btn btn-warning']) ?>

        <?= Html::a(Yii::t('cms', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger pull-right',
            'data' => [
                'confirm' => Yii::t('cms', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="box">
        <div class="box-body">
            <div class="row">
                <div class="col-sm-6">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'slug',
                            'name_0',
                            'name_1',
                            'name_2',
                            'name_3',
                            'name_4',
                        ],
                    ]) ?>
                </div>
                <div class="col-sm-6">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            'created_at:datetime',
                            'updated_at:datetime',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <p>
        <?= Html::a(Yii::t('cms', 'Add collection'), ['add-options', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>
    <?php if (count($model->options)): ?>
        <div class="box">
            <div class="box-body">
                <div class="row">
                    <?php foreach ($model->options as $cam): ?>
                        <div class="col-sm-3">
                            <p>
                                <?= Html::a(Yii::t('cms', 'Update'), ['update-options', 'id' => $model->id, 'camId' => $cam->id], ['class' => 'btn btn-sm btn-primary']) ?>
                                <?= Html::a(Yii::t('cms', 'Delete'), ['delete-options', 'id' => $model->id, 'camId' => $cam->id], [
                                    'class' => 'btn btn-sm btn-danger',
                                    'data' => [
                                        'confirm' => Yii::t('cms', 'Are you sure you want to delete this item?'),
                                        'method' => 'post',
                                    ],
                                ]) ?>
                            </p>
                            <?= DetailView::widget([
                                'model' => $cam,
                                'attributes' => [
                                    'id',
                                    [
                                        'attribute' => 'option_id',
                                        'label' => 'Option',
                                        'value' => $cam->option->slug
                                    ],
                                ]
                            ]) ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

</div>
