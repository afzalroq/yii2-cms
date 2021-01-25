<?php

use afzalroq\cms\entities\Menu;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\widgets\ListView;

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
            'class' => 'btn btn-danger',
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
                    <?php $nameAttrs = [];
                    foreach (Yii::$app->params['cms']['languages'] as $key => $language)
                        $nameAttrs[] = 'title_' . $key;

                    echo DetailView::widget([
                        'model' => $model,
                        'attributes' => array_merge($nameAttrs, [
                            [
                                'attribute' => 'parent_id',
                                'label' => Yii::t('cms', 'Parent'),
                                'value' => isset($model->parent) ? $model->parent->title_0 : null
                            ],
                            [
                                'attribute' => 'type',
                                'value' => $model->typesLists($model->type)
                            ],
                            [
                                'attribute' => 'type_helper',
                                'value' => $model->getTypeValue()
                            ],
                        ]),
                    ]) ?>
                </div>
                <div class="col-sm-6">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            'sort',
                            'created_at:datetime',
                            'updated_at:datetime',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <?php $form = \yii\bootstrap\ActiveForm::begin() ?>

            <?= $form->field($childForm, 'child_id')->dropDownList($childForm->getChildsList($model->id, $model->parent_id)); ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('cms', 'Create'), ['class' => 'btn btn-success']) ?>
            </div>
            <?php \yii\bootstrap\ActiveForm::end() ?>
        </div>
        <div class="col-sm-4">
            <?= ListView::widget([
                'dataProvider' => $childProvider,
                'options' => [
                    'tag' => 'ul',
                    'class' => 'list-group'
                ],
                'itemView' => function ($model) {
                    return Html::a($model->title_0, Url::to(['/cms/menu/view', 'id' => $model->id]));
                },
                'itemOptions' => [
                    'tag' => 'li',
                    'class' => 'list-group-item'
                ]
            ]) ?>
        </div>
    </div>
</div>
