<?php

use afzalroq\cms\components\FileType;
use afzalroq\cms\entities\Collections;
use afzalroq\cms\entities\Options;
use afzalroq\cms\widgets\CmsForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model Options */
/* @var $collection Collections */
/* @var $form ActiveForm */
/* @var $action string */

$hasTranslatableAttrs = 0;
?>

<div class="pages-form">

    <?php
    $form = ActiveForm::begin(['action' => $action]);
    $cmsForm = new CmsForm($form, $model, $collection);
    ?>

    <?= $form->field($model, 'collection_id')->hiddenInput(['value' => $collection->id])->label(false) ?>

    <?= $form->errorSummary($model) ?>

    <div class="box">
        <div class="box-body">
            <div class="row">
                <?php if ($collection->manual_slug): ?>
                    <div class="col-md-4">
                        <?= $form->field($model, 'slug')->textInput() ?>
                    </div>
                <?php endif; ?>
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

                    if (FileType::fileMimeType($collection->file_1_mimeType) === FileType::TYPE_AUDIO)
                        echo $cmsForm->file('file_1_0', 'file_1', $collection->option_file_1_label);

                    if (FileType::fileMimeType($collection->file_1_mimeType) === FileType::TYPE_VIDEO)
                        echo $cmsForm->file('file_1_0', 'file_1', $collection->option_file_1_label);
                }

                if ($collection->option_file_2 == Collections::OPTION_FILE_COMMON) {
                    if (FileType::fileMimeType($collection->file_2_mimeType) === FileType::TYPE_IMAGE)
                        echo $cmsForm->image('file_2_0', 'file_2', $collection->option_file_2_label);

                    if (FileType::fileMimeType($collection->file_2_mimeType) === FileType::TYPE_FILE)
                        echo $cmsForm->file('file_2_0', 'file_2', $collection->option_file_2_label);


                    if (FileType::fileMimeType($collection->file_1_mimeType) === FileType::TYPE_AUDIO)
                        echo $cmsForm->file('file_2_0', 'file_2', $collection->option_file_2_label);

                    if (FileType::fileMimeType($collection->file_1_mimeType) === FileType::TYPE_VIDEO)
                        echo $cmsForm->file('file_2_0', 'file_2', $collection->option_file_2_label);
                }
                ?>
            </div>
            <div class="row">
                <?= $cmsForm->textFieldsCommonCollection() ?>
            </div>
        </div>
    </div>

    <div class="box" id="translatable">
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

                        <?php
                        if ($collection->option_name && $collection->option_name == Collections::OPTION_NAME_TRANSLATABLE) {
                            $hasTranslatableAttrs = 1;
                            echo $form->field($model, 'name_' . $key)->textInput(['maxlength' => true]);
                        }

                        if ($collection->option_content == Collections::OPTION_CONTENT_TRANSLATABLE_TEXTAREA) {
                            $hasTranslatableAttrs = 1;
                            echo $form->field($model, 'content_' . $key)->textarea()->label(Yii::t('cms', 'Description'));
                        }
                        ?>

                        <?php
                        if ($collection->option_content == Collections::OPTION_CONTENT_TRANSLATABLE_CKEDITOR) {
                            $hasTranslatableAttrs = 1;
                            echo "<div class='row'>" .
                                $cmsForm->ckeditor('content_' . $key, Yii::t('cms', 'Description'))
                                . "</div>";
                        }
                        ?>

                        <div role="tabpanel" class="tab-pane <?= $i === 1 ? 'active' : '' ?>" id="<?= $key ?>">
                            <?= $cmsForm->textFieldsTranslatableCollection($key, $hasTranslatableAttrs) ?>
                        </div>

                        <div class="row">
                            <?php
                            if ($collection->option_file_1 == Collections::OPTION_FILE_TRANSLATABLE) {
                                $hasTranslatableAttrs = 1;
                                if (FileType::fileMimeType($collection->file_1_mimeType) === FileType::TYPE_IMAGE)
                                    echo $cmsForm->image('file_1_' . $key, 'file_1', $collection->option_file_1_label);

                                if (FileType::fileMimeType($collection->file_1_mimeType) === FileType::TYPE_FILE)
                                    echo $cmsForm->file('file_1_' . $key, 'file_1', $collection->option_file_1_label);
                                if (FileType::fileMimeType($collection->file_1_mimeType) === FileType::TYPE_VIDEO)
                                    echo $cmsForm->file('file_1_' . $key, 'file_1', $collection->option_file_1_label);
                                if (FileType::fileMimeType($collection->file_1_mimeType) === FileType::TYPE_AUDIO)
                                    echo $cmsForm->file('file_1_' . $key, 'file_1', $collection->option_file_1_label);
                            }

                            if ($collection->option_file_2 == Collections::OPTION_FILE_TRANSLATABLE) {
                                $hasTranslatableAttrs = 1;
                                if (FileType::fileMimeType($collection->file_2_mimeType) === FileType::TYPE_IMAGE)
                                    echo $cmsForm->image('file_2_' . $key, 'file_2', $collection->option_file_2_label);

                                if (FileType::fileMimeType($collection->file_2_mimeType) === FileType::TYPE_FILE)
                                    echo $cmsForm->file('file_2_' . $key, 'file_2', $collection->option_file_2_label);
                                if (FileType::fileMimeType($collection->file_2_mimeType) === FileType::TYPE_VIDEO)
                                    echo $cmsForm->file('file_2_' . $key, 'file_2', $collection->option_file_2_label);
                                if (FileType::fileMimeType($collection->file_2_mimeType) === FileType::TYPE_AUDIO)
                                    echo $cmsForm->file('file_2_' . $key, 'file_2', $collection->option_file_2_label);
                            }
                            ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <?php if ($collection->use_seo): ?>
        <div class="box">
            <div class="box-body">
                <?php if ($collection->use_seo == Collections::SEO_TRANSLATABLE): ?>
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
                                <?php $form->field($model, 'meta_title_' . $key)->hiddenInput()->label(false) ?>
                                <?= $form->field($model, 'meta_keyword_' . $key)->textInput() ?>
                                <?= $form->field($model, 'meta_des_' . $key)->textInput() ?>

                            </div>
                        <?php } ?>
                    </div>
                <?php else: ?>
                    <?php $form->field($model, 'meta_title_0')->hiddenInput()->label(false) ?>
                    <?= $form->field($model, 'meta_keyword_0')->textInput() ?>
                    <?= $form->field($model, 'meta_des_0')->textInput() ?>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('cms', $model->isNewRecord ? 'Create' : 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php \yii\widgets\ActiveForm::end(); ?>

    <script>
        if (!<?= $hasTranslatableAttrs ?>)
            document.querySelector('#translatable').innerHTML = ''
    </script>
</div>
