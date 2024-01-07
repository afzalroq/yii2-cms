<?php

use afzalroq\cms\entities\Collections;
use yii\helpers\Html;
use yii\widgets\DetailView;
use afzalroq\cms\entities\Entities;

/* @var $this yii\web\View */
/* @var $model Collections */

$this->title = $model->{'name_' . Yii::$app->params['l'][Yii::$app->language]};
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms', 'Collection'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$names = [];
foreach (Yii::$app->params['cms']['languages'] as $key => $language) {
    $names[] = [
        'attribute' => 'id',
        'label' => Yii::t('cms', 'Name') . " ($language)",
        'value' => function ($model) use ($key) {
            return $model->getName($key);
        },
    ];
}
?>
<div class="menu-view">

    <p>
        <?= Html::a(Yii::t('cms', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('cms', 'View options') . " <i class='fa fa-chevron-circle-right'></i>", ['/cms/options/index', 'slug' => $model->slug], ['class' => 'btn btn-warning']) ?>
        <?= Html::a(Yii::t('cms', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger pull-right',
            'data' => ['confirm' => Yii::t('cms', 'Are you sure you want to delete this item?'), 'method' => 'post']
        ]) ?>
    </p>


    <div class="box">
        <div class="box-body">
            <div class="row">
                <div class="col-sm-6">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => array_merge(
                            [
                                'id',
                                'slug'
                            ],
                            $names,
                            [
                                [
                                    'attribute' => 'text_1',
                                    'value' => function ($model) {
                                        return Entities::textList()[$model->text_1 ?: 0];
                                    }
                                ],
                                [
                                    'attribute' => 'text_2',
                                    'value' => function ($model) {
                                        return Entities::textList()[$model->text_2 ?: 0];
                                    }
                                ],
                                [
                                    'attribute' => 'text_3',
                                    'value' => function ($model) {
                                        return Entities::textList()[$model->text_3 ?: 0];
                                    }
                                ],
                                [
                                    'attribute' => 'text_4',
                                    'value' => function ($model) {
                                        return Entities::textList()[$model->text_4 ?: 0];
                                    }
                                ],
                            ],
                            [
                                'created_at:datetime',
                                'updated_at:datetime'
                            ]
                        )
                    ]) ?>
                </div>
                <div class="col-sm-6">
                    <?= DetailView::widget(['model' => $model,
                        'attributes' => [
                            ['attribute' => 'use_in_menu',
                                'value' => Collections::optionUseInMenuList()[$model->use_in_menu]],
                            ['attribute' => 'use_parenting',
                                'value' => $model->use_parenting ? Yii::t('cms', 'Yes') : Yii::t('cms', 'No')],
                            ['attribute' => 'use_seo',
                                'value' => $model->use_seo ? Yii::t('cms', 'Yes') : Yii::t('cms', 'No')],
                            ['attribute' => 'manual_slug',
                                'value' => $model->manual_slug ? Yii::t('cms', 'Yes') : Yii::t('cms', 'No')],
                            ['attribute' => 'text_1_label',
                                'value' => $model->text_1_label],
                            ['attribute' => 'text_2_label',
                                'value' => $model->text_2_label],
                            ['attribute' => 'text_3_label',
                                'value' => $model->text_3_label],
                            ['attribute' => 'text_4_label',
                                'value' => $model->text_4_label],
                            ['attribute' => 'option_name',
                                'value' => Yii::t('cms', Collections::optionNameList()[$model->option_name])],
                            ['attribute' => 'option_content',
                                'value' => Yii::t('cms', Collections::optionContentList()[$model->option_content])],

                        ]]) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="box">
        <div class="box-header">
            <h3>Files</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-sm-6">
                    <?= DetailView::widget(['model' => $model,
                        'attributes' => [['attribute' => 'option_file_1',
                            'value' => Yii::t('cms', Collections::optionFileList()[$model->option_file_1])],
                            'option_file_1_label',
                            ['attribute' => 'file_1_mimeType',
                                'value' => $model->getFile1MimeType()],
                            'file_1_dimensionW',
                            'file_1_dimensionH',
                            ['attribute' => 'file_1_maxSize',
                                'value' => $model->getFile1MaxSize()]]]) ?>
                </div>
                <div class="col-sm-6">
                    <?= DetailView::widget(['model' => $model,
                        'attributes' => [['attribute' => 'option_file_2',
                            'value' => Yii::t('cms', Collections::optionFileList()[$model->option_file_2])],
                            'option_file_2_label',
                            ['attribute' => 'file_2_mimeType',
                                'value' => $model->getFile2MimeType()],
                            'file_2_dimensionW',
                            'file_2_dimensionH',
                            ['attribute' => 'file_2_maxSize',
                                'value' => $model->getFile2MaxSize()]]]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
