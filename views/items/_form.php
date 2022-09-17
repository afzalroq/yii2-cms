<?php

use afzalroq\cms\entities\CaE;
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

        .cms-form-checkbox_list label{
            padding-right: 10px;
        }
    </style>
    <div class="sticky">
        <?php if (!$entity->disable_create_and_delete) {
            echo Html::submitButton('<i class="fa fa-plus"></i> ' . Yii::t('cms', 'Save and Add new'), ['class' => 'btn btn-success', 'name' => 'save', 'value' => 'add-new']);
        } ?>
        <?= Html::submitButton('<i class="fa fa-check"></i> ' . Yii::t('cms', 'Save and Close'), ['class' => 'btn btn-warning', 'name' => 'save', 'value' => 'save-close']) ?>
        <?= Html::submitButton('<i class="fa fa-refresh"></i> ' . Yii::t('cms', 'Save'), ['class' => 'btn btn-primary', 'name' => 'save', 'value' => 'save']) ?>
        <?= Html::a('<i class="fa fa-close"></i> ' . Yii::t('cms', 'Close'), ['/cms/items/index', 'slug' => $entity->slug], ['class' => 'btn btn-danger pull-right', 'name' => 'save', 'value' => 'close', 'style' => 'margin-right: 10px;']) ?>
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
                <?= $cmsForm->oaIFields(CaE::Location_Top); ?>
            </div>
        </div>
    </div>

    <!--#region Common -->
    <?php if ($entity->hasCommonTexts() || $entity->hasCommonDate()): ?>
        <div class="box">
            <div class="box-body">
                <div class="row">
                    <?= $cmsForm->dateFieldCommon('date') ?>
                    <?= $cmsForm->textFieldsCommon() ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <!--#endregion -->


    <!--#region Translatable -->
    <div class="row" id="translatable">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <ul class="nav nav-tabs" role="tablist">
                        <?php
                        $i = 0;
                        foreach (Yii::$app->params['cms']['languages'] as $key => $language) {
                            $i++;
                            ?>
                            <li role="presentation" <?= $i === 1 ? 'class="active"' : '' ?>>
                                <a href="#<?= $key ?>" aria-controls="<?= $key ?>" role="tab"
                                   data-toggle="tab"><?= $language ?></a>
                            </li>
                        <?php } ?>
                    </ul>
                    <div class="tab-content">
                        <br>
                        <?php
                        $i = 0;
                        foreach (Yii::$app->params['cms']['languages'] as $key => $language) {
                            $i++;
                            ?>
                            <div role="tabpanel" class="tab-pane <?= $i === 1 ? 'active' : '' ?>" id="<?= $key ?>">
                                <?= $cmsForm->dateFieldTranslatable($key, 'date') ?>
                                <?= $cmsForm->textFieldsTranslatable($key, $hasTranslatableAttrs) ?>
                                <?= $cmsForm->fileFieldsTranslatable($key, $hasTranslatableAttrs) ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--#endregion -->
    <div class="box">
        <div class="box-body">
            <div class="row">
                <?= $cmsForm->oaIFields(CaE::Location_Bottom); ?>
            </div>
        </div>
    </div>


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

    <?php if ($entity->hasCommonFiles()): ?>
        <div class="box">
            <div class="box-body">
                <?= $cmsForm->fileFieldsCommon() ?>
            </div>
        </div>
    <?php endif; ?>

    <!--#region Translatable Seo -->
    <?php if ($entity->use_seo > 0): ?>
        <div class="row">
            <div class="col-md-12">
                <hr>
                <div class="box">
                    <div class="box-body">
                        <?php if ($entity->use_seo == Entities::SEO_TRANSLATABLE): ?>
                            <ul class="nav nav-tabs" role="tablist">
                                <?php
                                $i = 0;
                                foreach (Yii::$app->params['cms']['languages'] as $key => $language) {
                                    $i++;
                                    ?>
                                    <li role="presentation" <?= $i === 1 ? 'class="active"' : '' ?>>
                                        <a href="#<?= $key ?>S" aria-controls="<?= $key ?>S" role="tab"
                                           data-toggle="tab"><?= $language ?></a>
                                    </li>
                                <?php } ?>
                            </ul>
                            <div class="tab-content">
                                <br>
                                <?php
                                $i = 0;
                                foreach (Yii::$app->params['cms']['languages'] as $key => $language) {
                                    $i++;
                                    ?>
                                    <div role="tabpanel" class="tab-pane <?= $i === 1 ? 'active' : '' ?>" id="<?= $key ?>S">

                                        <?php $form->field($model, 'meta_title_' . $key)->textInput() ?>
                                        <?= $form->field($model, 'meta_keyword_' . $key)->textarea() ?>
                                        <?= $form->field($model, 'meta_des_' . $key)->textarea() ?>

                                    </div>
                                <?php } ?>
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

    <?php ActiveForm::end(); ?>


    <script>
        if (!<?= $hasTranslatableAttrs ?>)
            document.querySelector('#translatable').innerHTML = ''
    </script>
</div>
