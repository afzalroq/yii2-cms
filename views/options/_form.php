<?php

use afzalroq\cms\components\FileType;
use afzalroq\cms\entities\Collections;
use afzalroq\cms\entities\Options;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

//use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model Options */
/* @var $collection Collections */
/* @var $form ActiveForm */

$hasTranslatableAttrs = 0;
?>

<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div style="margin:5px 0 0 0;" class="alert alert-success"><?= Yii::$app->session->getFlash('success') ?></div>
<?php endif; ?>
<div class="pages-form">

    <?php $form = ActiveForm::begin();
    $cmsForm = new \afzalroq\cms\widgets\CmsForm($form, $model, $collection)
    ?>

    <?= $form->field($model, 'collection_id')->textInput(['value' => $collection->id, 'type' => 'hidden'])->label(false) ?>

    <?= $form->errorSummary($model) ?>

    <div class="box">
        <div class="box-body">
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'slug')->textInput() ?>
                </div>
                <?php $optionIdList = ArrayHelper::map(Options::findAll(['collection_id' => $collection->id]), 'id', 'slug');
                unset($optionIdList[$model->id]);

                if ($optionIdList): ?>
                    <div class="col-md-4">
                        <?= $form->field($model, 'parent_id')->dropDownList($optionIdList, ['prompt' => 'Please select', 'options' => ['value' => 'none', 'class' => 'prompt', 'label' => 'Select']]) ?>
                    </div>
                <?php endif; ?>
                <div class="col-md-4">
                    <?= $form->field($model, 'sort')->textInput(['type' => 'number']) ?>
                </div>
            </div>
            <div class="row">
                <?php if ($collection->option_name == Collections::OPTION_NAME_COMMON): ?>
                    <div class="col-md-6">
                        <?= $form->field($model, 'name_0')->textInput()->label(Yii::t('cms', 'Title')) ?>
                    </div>
                <?php endif; ?>
                <?php if ($collection->option_content == Collections::OPTION_CONTENT_COMMON_TEXTAREA): ?>
                    <div class="col-md-6">
                        <?= $form->field($model, 'content_0')->textarea()->label(Yii::t('cms', 'Description')) ?>
                    </div>
                <?php endif; ?>

                <?php
                if ($collection->option_content == Collections::OPTION_CONTENT_COMMON_CKEDITOR)
                    echo $cmsForm->ckeditor('content_0', Yii::t('cms', 'Description'))
                ?>

                <?php
                if ($collection->option_file_1 == Collections::OPTION_FILE_COMMON) {
                    if (FileType::fileMimeType($collection->file_1_mimeType) === FileType::TYPE_IMAGE)
                        echo $cmsForm->image('file_1_0', 'file_1', $collection->option_file_1_label);

                    if (FileType::fileMimeType($collection->file_1_mimeType) === FileType::TYPE_FILE)
                        echo $cmsForm->file('file_1_0', 'file_1', $collection->option_file_1_label);
                }

                if ($collection->option_file_2 == Collections::OPTION_FILE_COMMON) {
                    if (FileType::fileMimeType($collection->file_2_mimeType) === FileType::TYPE_IMAGE)
                        echo $cmsForm->image('file_2_0', 'file_2', $collection->option_file_2_label);

                    if (FileType::fileMimeType($collection->file_2_mimeType) === FileType::TYPE_FILE)
                        echo $cmsForm->file('file_2_0', 'file_2', $collection->option_file_2_label);
                }
                ?>
            </div>
        </div>
    </div>

    <div class="row" id="translatable">
        <div class="col-md-12">
            <hr>
            <div class="box">
                <div class="box-body">
                    <ul class="nav nav-tabs" role="tablist">
                        <?php foreach (Yii::$app->params['cms']['languages2'] as $key => $language) : ?>
                            <li role="presentation" <?= $key == 0 ? 'class="active"' : '' ?>>
                                <a href="#<?= $key ?>" aria-controls="<?= $key ?>" role="tab"
                                   data-toggle="tab"><?= $language ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="tab-content">
                        <br>
                        <?php foreach (Yii::$app->params['cms']['languages2'] as $key => $language) : ?>
                            <div role="tabpanel" class="tab-pane <?= $key == 0 ? 'active' : '' ?>" id="<?= $key ?>">

                                <?php
                                if ($collection->option_name && $collection->option_name == Collections::OPTION_NAME_TRANSLATABLE) {
                                    $hasTranslatableAttrs = 1;
                                    echo $form->field($model, 'name_' . $key)->textInput(['maxlength' => true]);
                                } ?>

                                <?php if ($collection->option_content == Collections::OPTION_CONTENT_TRANSLATABLE_TEXTAREA): $hasTranslatableAttrs = 1 ?>
                                    <div class="col-md-6">
                                        <?= $form->field($model, 'content_' . $key)->textarea()->label(Yii::t('cms', 'Description')) ?>
                                    </div>
                                <?php endif; ?>

                                <?php
                                if ($collection->option_content == Collections::OPTION_CONTENT_TRANSLATABLE_CKEDITOR) {
                                    $hasTranslatableAttrs = 1;
                                    echo $cmsForm->ckeditor('content_' . $key, Yii::t('cms', 'Description'));
                                } ?>


                                <div class="row">
                                    <?php
                                    if ($collection->option_file_1 == Collections::OPTION_FILE_TRANSLATABLE) {
                                        $hasTranslatableAttrs = 1;
                                        if (FileType::fileMimeType($collection->file_1_mimeType) === FileType::TYPE_IMAGE)
                                            echo $cmsForm->image('file_1_' . $key, 'file_1', $collection->option_file_1_label);

                                        if (FileType::fileMimeType($collection->file_1_mimeType) === FileType::TYPE_FILE)
                                            echo $cmsForm->file('file_1_' . $key, 'file_1', $collection->option_file_1_label);
                                    }

                                    if ($collection->option_file_2 == Collections::OPTION_FILE_TRANSLATABLE) {
                                        $hasTranslatableAttrs = 1;
                                        if (FileType::fileMimeType($collection->file_2_mimeType) === FileType::TYPE_IMAGE)
                                            echo $cmsForm->image('file_2_' . $key, 'file_2', $collection->option_file_2_label);

                                        if (FileType::fileMimeType($collection->file_2_mimeType) === FileType::TYPE_FILE)
                                            echo $cmsForm->file('file_2_' . $key, 'file_2', $collection->option_file_2_label);
                                    }
                                    ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if ($collection->use_seo): ?>
        <div class="row">
            <div class="col-md-12">
                <hr>
                <div class="box">
                    <div class="box-body">
                        <?php if ($collection->use_seo == Collections::SEO_TRANSLATABLE): ?>
                            <ul class="nav nav-tabs" role="tablist">
                                <?php foreach (Yii::$app->params['cms']['languages2'] as $key => $language) : ?>
                                    <li role="presentation" <?= $key == 0 ? 'class="active"' : '' ?>>
                                        <a href="#<?= $key ?>S" aria-controls="<?= $key ?>S" role="tab"
                                           data-toggle="tab"><?= $language ?></a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            <div class="tab-content">
                                <br>
                                <?php foreach (Yii::$app->params['cms']['languages2'] as $key => $language) : ?>
                                    <div role="tabpanel" class="tab-pane <?= $key == 0 ? 'active' : '' ?>" id="<?= $key ?>S">

                                        <?= $form->field($model, 'meta_title_' . $key)->textInput() ?>
                                        <?= $form->field($model, 'meta_keyword_' . $key)->textInput() ?>
                                        <?= $form->field($model, 'meta_des_' . $key)->textInput() ?>

                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <?= $form->field($model, 'meta_title_0')->textInput() ?>
                            <?= $form->field($model, 'meta_keyword_0')->textInput() ?>
                            <?= $form->field($model, 'meta_des_0')->textInput() ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('cms', $model->isNewRecord ? 'Create' : 'Update'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php \yii\widgets\ActiveForm::end(); ?>

    <script>
        if (!<?= $hasTranslatableAttrs ?>)
            document.querySelector('#translatable').innerHTML = ''
    </script>
</div>
