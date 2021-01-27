<?php

use afzalroq\cms\entities\Menu;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model Menu */
/* @var $childForm \afzalroq\cms\forms\MenuAddChildForm */

$this->title = $model->title_0;

$this->params['breadcrumbs'][] = ['label' => Yii::t('cms', 'Menu'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="menu-view">
    <p>
        <?= Html::a(Yii::t('yii', 'Home'), ['index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a(Yii::t('cms', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('cms', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger pull-right',
            'data' => [
                'confirm' => Yii::t('cms', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a(Yii::t('cms', 'Add Child'), ['create-child', 'root_id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="box">
        <div class="box-body">
            <div class="row">
                <div class="col-sm-6">
                    <?php $nameAttrs = [];
                    foreach (Yii::$app->params['cms']['languages'] as $key => $language)
                        $nameAttrs[] = 'title_' . $key;

                    echo DetailView::widget([
                        'model' => $model,
                        'attributes' => $nameAttrs
                    ]) ?>
                </div>
                <div class="col-sm-6">
                    <?= DetailView::widget(['model' => $model,
                        'attributes' => ['created_at:datetime',
                            'updated_at:datetime',
                            ['attribute' => 'type',
                                'value' => $model->typesLists($model->type)],
                            ['attribute' => 'type_helper',
                                'value' => $model->getTypeValue()],],]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
