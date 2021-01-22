<?php

use afzalroq\cms\components\FileType;
use afzalroq\cms\entities\Collections;
use yii\bootstrap\ToggleButtonGroup;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use afzalroq\cms\entities\Options;

/* @var $this yii\web\View */
/* @var $model Collections */
/* @var $form yii\widgets\ActiveForm */


?>

<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div style="margin:5px 0 0 0;" class="alert alert-success"><?= Yii::$app->session->getFlash('success') ?></div>
<?php endif; ?>
<style>
    #collections-file_1_mimetype, #collections-file_2_mimetype, #collections-option_name, #collections-option_content, #collections-use_seo, #collections-use_in_menu {
        border-color: transparent;
    }
</style>
<div class="pages-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model) ?>

    <div class="box">
        <div class="box-body">
            <div class="row">

                <div class="col-sm-4">
                    <?php foreach (Yii::$app->params['cms']['languages'] as $key => $language) : ?>
                        <?= $form->field($model, 'name_' . $key)->textInput(['maxlength' => true]) ?>
                    <?php endforeach; ?>
                </div>

                <div class="col-sm-4">
                    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'use_parenting')->checkbox() ?>
<!--                    --><?//= $form->field($model, 'slug')->checkbox() ?>
                </div>

                <div class="col-sm-4">
                    <?php $model->use_in_menu = $model->isNewRecord ? Collections::USE_IN_MENU_DISABLED : $model->use_in_menu ?>
                    <?= $form->field($model, 'use_in_menu')->widget(ToggleButtonGroup::class, [
                        'type' => 'radio',
                        'items' => Collections::optionUseInMenuList(),
                        'labelOptions' => [
                            'class' => 'btn btn-info'
                        ]
                    ]) ?>
                    <br>
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
        </div>
    </div>

    <div class="box">
        <div class="box-header"><h3>Options</h3></div>
        <div class="box-body">
            <div class="row">
                <div class="col-sm-4">
                    <?php $model->option_name = $model->isNewRecord ? Collections::OPTION_NAME_DISABLED : $model->option_name ?>
                    <?= $form->field($model, 'option_name')->widget(ToggleButtonGroup::class, [
                        'type' => 'radio',
                        'items' => Collections::optionNameList(),
                        'labelOptions' => [
                            'class' => 'btn btn-info'
                        ]
                    ]) ?>
                </div>
                <div class="col-sm-8">
                    <?php $model->option_content = $model->isNewRecord ? Collections::OPTION_CONTENT_DISABLED : $model->option_content ?>
                    <?= $form->field($model, 'option_content')->widget(ToggleButtonGroup::class, [
                        'type' => 'radio',
                        'items' => Collections::optionContentList(),
                        'labelOptions' => [
                            'class' => 'btn btn-info'
                        ]
                    ]) ?>
                </div>
            </div>
            <br>
            <br>
            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($model, 'option_file_1')->dropDownList(Collections::optionFileList()) ?>
                    <?= $form->field($model, 'option_file_1_label')->textInput() ?>
                    <?= $form->field($model, 'file_1_mimeType')->widget(ToggleButtonGroup::class, [
                        'type' => 'checkbox',
                        'items' => FileType::MIME_TYPES,
                        'labelOptions' => [
                            'class' => 'btn btn-info'
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
                <div class="col-sm-4">
                    <?= $form->field($model, 'option_file_2')->dropDownList(Collections::optionFileList()) ?>
                    <?= $form->field($model, 'option_file_2_label')->textInput() ?>
                    <?= $form->field($model, 'file_2_mimeType')->widget(ToggleButtonGroup::class, [
                        'type' => 'checkbox',
                        'items' => FileType::MIME_TYPES,
                        'labelOptions' => [
                            'class' => 'btn btn-info'
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
                <div class="col-sm-4">
                    <?php if (!$model->isNewRecord): ?>
                        <?= $form->field($model, 'option_default_id')->dropDownList(ArrayHelper::map(Options::findAll(['collection_id' => $model->id]), 'id', 'slug'), [
                            'prompt' => ''
                        ]) ?>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('cms', 'Create') : Yii::t('cms', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>


    <?php ActiveForm::end(); ?>
</div>
