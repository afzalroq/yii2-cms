<?php

use afzalroq\cms\components\FileType;
use afzalroq\cms\entities\Collections;
use afzalroq\cms\entities\Entities;
use yii\bootstrap\ToggleButtonGroup;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model afzalroq\cms\entities\Entities */
/* @var $form yii\widgets\ActiveForm */
?>

<style>
    #entities-use_date,
    #entities-use_seo,
    #entities-file_1_mimetype,
    #entities-file_2_mimetype,
    #entities-file_3_mimetype {
        border-color: transparent;
    }
</style>
<div class="entities-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model) ?>

    <div class="box">
        <div class="box-body">
            <div class="row">
                <div class="col-md-3">
                    <?php foreach (Yii::$app->params['cms']['languages'] as $key => $language) : ?>
                        <?= $form->field($model, 'name_' . $key)->textInput(['maxlength' => true]) ?>
                    <?php endforeach; ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'manual_slug')->checkbox() ?>
                    <?= $form->field($model, 'use_in_menu')->checkbox() ?>
                    <?= $form->field($model, 'use_gallery')->checkbox() ?>
                    <?= $form->field($model, 'use_status')->checkbox() ?>
                    <?= $form->field($model, 'use_views_count')->checkbox() ?>
                    <?= $form->field($model, 'disable_create_and_delete')->checkbox() ?>
                    <?= $form->field($model, 'use_watermark')->checkbox() ?>
                </div>
                <div class="col-md-3">
                    <div class="row">
                    <?php $model->use_date = $model->isNewRecord ? Entities::USE_DATE_DISABLED : $model->use_date ?>
                    <?= $form->field($model, 'use_date')->widget(ToggleButtonGroup::class, [
                        'type' => 'radio',
                        'items' => Entities::dateList(),
                        'labelOptions' => ['class' => 'btn-info tbg']
                    ]) ?>
                    </div>
                    <br>
                    <br>
                    <div class="row">
                    <?php $model->use_seo = $model->isNewRecord ? Collections::SEO_DISABLED : $model->use_seo ?>
                    <?= $form->field($model, 'use_seo')->widget(ToggleButtonGroup::class, [
                        'type' => 'radio',
                        'items' => Collections::seoList(),
                        'labelOptions' => [
                            'class' => 'btn btn-info'
                        ]
                    ]) ?>
                    </div>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'use_comments')->widget(ToggleButtonGroup::class, [
                        'type' => 'radio',
                        'items' => Entities::getCommentTextUseOrNot(),
                        'labelOptions' => ['class' => 'btn-info tbg']
                    ]) ?>
                    <?= $form->field($model, 'use_votes')->widget(ToggleButtonGroup::class, [
                        'type' => 'radio',
                        'items' => Entities::getCommentTextUseOrNot(),
                        'labelOptions' => ['class' => 'btn-info tbg']
                    ]) ?>

                    <?= $form->field($model, 'max_level')->textInput(['type'=>'number','min' => 0,'max' => 3]) ?>
                    <?= $form->field($model, 'use_moderation')->checkbox([]) ?>
                    <?= $form->field($model, 'comment_without_login')->checkbox([]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="box">
                <div class="box-body">
                    <?= $form->field($model, 'text_1')->dropDownList(Entities::textList()) ?>
                    <?= $form->field($model, 'text_1_label')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="box">
                <div class="box-body">
                    <?= $form->field($model, 'text_2')->dropDownList(Entities::textList()) ?>
                    <?= $form->field($model, 'text_2_label')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="box">
                <div class="box-body">
                    <?= $form->field($model, 'text_3')->dropDownList(Entities::textList()) ?>
                    <?= $form->field($model, 'text_3_label')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="box">
                <div class="box-body">
                    <?= $form->field($model, 'text_4')->dropDownList(Entities::textList()) ?>
                    <?= $form->field($model, 'text_4_label')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="box">
                <div class="box-body">
                    <?= $form->field($model, 'text_5')->dropDownList(Entities::textList()) ?>
                    <?= $form->field($model, 'text_5_label')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="box">
                <div class="box-body">
                    <?= $form->field($model, 'text_6')->dropDownList(Entities::textList()) ?>
                    <?= $form->field($model, 'text_6_label')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="box">
                <div class="box-body">
                    <?= $form->field($model, 'text_7')->dropDownList(Entities::textList()) ?>
                    <?= $form->field($model, 'text_7_label')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="box">
                <div class="box-body">
                    <?= $form->field($model, 'file_1')->dropDownList(Entities::fileList()) ?>
                    <?= $form->field($model, 'file_1_label')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'file_1_mimeType')->widget(ToggleButtonGroup::class, [
                        'type' => 'checkbox',
                        'items' => FileType::MIME_TYPES,
                        'labelOptions' => [
                            'class' => 'btn btn-info btn-sm tbg'
                        ]
                    ]) ?>
                    <br>
                    <div class="row">
                        <div class="col-sm-6">
                            <?= $form->field($model, 'file_1_dimensionW')->textInput(['type' => 'number']) ?>
                        </div>
                        <div class="col-sm-6">
                            <?= $form->field($model, 'file_1_dimensionH')->textInput(['type' => 'number']) ?>
                        </div>
                    </div>
                    <?= $form->field($model, 'file_1_maxSize')->textInput(['type' => 'number']) ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box">
                <div class="box-body">
                    <?= $form->field($model, 'file_2')->dropDownList(Entities::fileList()) ?>
                    <?= $form->field($model, 'file_2_label')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'file_2_mimeType')->widget(ToggleButtonGroup::class, [
                        'type' => 'checkbox',
                        'items' => FileType::MIME_TYPES,
                        'labelOptions' => [
                            'class' => 'btn btn-info btn-sm tbg'
                        ]
                    ]) ?>
                    <br>
                    <div class="row">
                        <div class="col-sm-6">
                            <?= $form->field($model, 'file_2_dimensionW')->textInput(['type' => 'number']) ?>
                        </div>
                        <div class="col-sm-6">
                            <?= $form->field($model, 'file_2_dimensionH')->textInput(['type' => 'number']) ?>
                        </div>
                    </div>
                    <?= $form->field($model, 'file_2_maxSize')->textInput(['type' => 'number']) ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box">
                <div class="box-body">
                    <?= $form->field($model, 'file_3')->dropDownList(Entities::fileList()) ?>
                    <?= $form->field($model, 'file_3_label')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'file_3_mimeType')->widget(ToggleButtonGroup::class, [
                        'type' => 'checkbox',
                        'items' => FileType::MIME_TYPES,
                        'labelOptions' => [
                            'class' => 'btn btn-info btn-sm tbg'
                        ]
                    ]) ?>
                    <br>
                    <div class="row">
                        <div class="col-sm-6">
                            <?= $form->field($model, 'file_3_dimensionW')->textInput(['type' => 'number']) ?>
                        </div>
                        <div class="col-sm-6">
                            <?= $form->field($model, 'file_3_dimensionH')->textInput(['type' => 'number']) ?>
                        </div>
                    </div>
                    <?= $form->field($model, 'file_3_maxSize')->textInput(['type' => 'number']) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('cms', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>