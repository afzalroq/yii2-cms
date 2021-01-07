<?php

use afzalroq\cms\entities\Entities;
use afzalroq\cms\components\FileType;
use yii\bootstrap\ToggleButtonGroup;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model afzalroq\cms\entities\Entities */
/* @var $form yii\widgets\ActiveForm */
?>

<style>
    #entities-use_date,
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
                    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
                </div>
                <?php foreach (Yii::$app->params['cms']['languages2'] as $key => $language) : ?>
                    <div class="col-md-3">
                        <?= $form->field($model, 'name_' . $key)->textInput(['maxlength' => true]) ?>
                    </div>
                <?php endforeach; ?>
                <div class="col-md-3">
                    <?= $form->field($model, 'use_date')->widget(ToggleButtonGroup::class, [
                        'type' => 'radio',
                        'items' => Entities::dateList(),
                        'labelOptions' => ['class' => 'btn-default btn-sm tbg']
                    ]) ?>
                </div>
                <div class="col-md-3">
                    <br>
                    <?= $form->field($model, 'use_status')->checkbox() ?>
                </div>
                <div class="col-md-3">
                    <br>
	                <?= $form->field($model, 'use_in_menu')->checkbox() ?>
                </div>
                <div class="col-md-3">
                    <br>
                    <?= $form->field($model, 'use_seo')->checkbox() ?>
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
                        'type' => 'radio',
                        'items' => FileType::MIME_TYPES,
                        'labelOptions' => [
                            'class' => 'btn btn-default btn-sm tbg'
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
                        'type' => 'radio',
                        'items' => FileType::MIME_TYPES,
                        'labelOptions' => [
                            'class' => 'btn btn-default btn-sm tbg'
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
                        'type' => 'radio',
                        'items' => FileType::MIME_TYPES,
                        'labelOptions' => [
                            'class' => 'btn btn-default btn-sm tbg'
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
