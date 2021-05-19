<?php

use afzalroq\cms\entities\Entities;
use afzalroq\cms\widgets\CmsForm;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model afzalroq\cms\entities\Items */
/* @var $form yii\widgets\ActiveForm */
/* @var $entity Entities */

$hasTranslatableAttrs = 0;
?>

<div class="items-form">
    <?php
    $form = ActiveForm::begin([
        'fieldConfig' => [
            'options' => [
                'enableClientValidation' => false,
                'enableAjaxValidation' => true
            ]
        ]
    ]);

    $cmsForm = new CmsForm($form, $model, $entity);
    ?>

    <style>
        .wrapper {
            overflow-x: initial;
            overflow-y: initial;
        }
        .sticky {
            position: sticky;
            top: 0;
            z-index: 999;
            padding: 10px 0 10px 10px;
            background: #fff;
            border: 1px solid #ccc;
        }
    </style>
    <div class="sticky">
        <?= Html::submitButton('<i class="fa fa-plus"></i> ' . Yii::t('cms', 'Save and Add new'), ['class' => 'btn btn-primary', 'name' => 'save', 'value' => 'addNew']) ?>
        <?= Html::submitButton('<i class="fa fa-check"></i> ' . Yii::t('cms', 'Save and Close'), ['class' => 'btn btn-warning', 'name' => 'save', 'value' => 'saveClose']) ?>
        <?= Html::submitButton('<i class="fa fa-refresh"></i> ' . Yii::t('cms', 'Save'), ['class' => 'btn btn-success', 'name' => 'save', 'value' => 'save']) ?>
        <?= Html::submitButton('<i class="fa fa-close"></i> ' . Yii::t('cms', 'Close'), ['class' => 'btn btn-danger pull-right', 'name' => 'save', 'value' => 'close', 'style' => 'margin-right: 10px;']) ?>
    </div>
    <?= $form->errorSummary($model) ?>
    <?= $form->field($model, 'entity_id')->textInput(['value' => $entity->id, 'type' => 'hidden'])->label(false) ?>

    <div class="box">
        <div class="box-body">
            <div class="row">
                <?php if ($entity->manual_slug): ?>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'slug')->textInput() ?>
                    </div>
                <?php endif; ?>
                <?= $cmsForm->oaIFields(); ?>
            </div>
        </div>
    </div>

    <!--#region Common -->
    <div class="box">
        <div class="box-body">
            <div class="row">
                <?= $cmsForm->dateFieldCommon('date') ?>

                <?= $cmsForm->textFieldsCommon() ?>
                <?= $cmsForm->fileFieldsCommon() ?>
            </div>
        </div>
    </div>
    <!--#endregion -->

    <!--#region Translatable -->
    <div class="row" id="translatable">
        <div class="col-md-12">
            <hr>
            <div class="box">
                <div class="box-body">
                    <ul class="nav nav-tabs" role="tablist">
                        <?php foreach (Yii::$app->params['cms']['languages'] as $key => $language) : ?>
                            <li role="presentation" <?= $key == 0 ? 'class="active"' : '' ?>>
                                <a href="#<?= $key ?>" aria-controls="<?= $key ?>" role="tab"
                                   data-toggle="tab"><?= $language ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="tab-content">
                        <br>
                        <?php foreach (Yii::$app->params['cms']['languages'] as $key => $language) : ?>
                            <div role="tabpanel" class="tab-pane <?= $key == 0 ? 'active' : '' ?>" id="<?= $key ?>">
                                <?= $cmsForm->dateFieldTranslatable($key, 'date') ?>
                                <?= $cmsForm->textFieldsTranslatable($key, $hasTranslatableAttrs) ?>
                                <?= $cmsForm->fileFieldsTranslatable($key, $hasTranslatableAttrs) ?>

                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--#endregion -->

    <!--#region Translatable Seo -->
    <?php if ($entity->use_seo > 0): ?>
        <div class="row">
            <div class="col-md-12">
                <hr>
                <div class="box">
                    <div class="box-body">
                        <?php if ($entity->use_seo == Entities::SEO_TRANSLATABLE): ?>
                            <ul class="nav nav-tabs" role="tablist">
                                <?php foreach (Yii::$app->params['cms']['languages'] as $key => $language) : ?>
                                    <li role="presentation" <?= $key == 0 ? 'class="active"' : '' ?>>
                                        <a href="#<?= $key ?>S" aria-controls="<?= $key ?>S" role="tab"
                                           data-toggle="tab"><?= $language ?></a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            <div class="tab-content">
                                <br>
                                <?php foreach (Yii::$app->params['cms']['languages'] as $key => $language) : ?>
                                    <div role="tabpanel" class="tab-pane <?= $key == 0 ? 'active' : '' ?>" id="<?= $key ?>S">

                                        <?php $form->field($model, 'meta_title_' . $key)->textInput() ?>
                                        <?= $form->field($model, 'meta_keyword_' . $key)->textarea() ?>
                                        <?= $form->field($model, 'meta_des_' . $key)->textarea() ?>

                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <?php $form->field($model, 'meta_title_0')->textInput() ?>
                            <?= $form->field($model, 'meta_keyword_0')->textarea() ?>
                            <?= $form->field($model, 'meta_des_0')->textarea() ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <!--#endregion -->

    <?php if ($entity->use_gallery): ?>
        <div class="box box-default">
            <div class="box-body">
                <?= $form->field($model, 'files[]')->widget(FileInput::class, [
                    'options' => [
                        'accept' => 'image/*',
                        'multiple' => true,
                    ]
                ]) ?>
            </div>
        </div>
    <?php endif; ?>

    <?php ActiveForm::end(); ?>


    <script>
        if (!<?= $hasTranslatableAttrs ?>)
            document.querySelector('#translatable').innerHTML = ''
    </script>
</div>
