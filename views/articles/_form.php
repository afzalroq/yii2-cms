<?php

use abdualiym\cms\entities\Articles;
use mihaildev\elfinder\ElFinder;
use sadovojav\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model Articles */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="articles-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model) ?>

    <div class="row">
        <div class="col-sm-8">

            <div class="box">
                <div class="box-body">
                    <ul class="nav nav-tabs" role="tablist">
                        <?php foreach (Yii::$app->params['cms']['languages2'] as $key => $language) : ?>
                            <li role="presentation" <?= $key == 0 ? 'class="active"' : '' ?>>
                                <a href="#<?= $key ?>" aria-controls="<?= $key ?>" role="tab" data-toggle="tab"><?= $language ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="tab-content">
                        <br>
                        <?php foreach (Yii::$app->params['cms']['languages2'] as $key => $language) : ?>
                            <div role="tabpanel" class="tab-pane <?= $key == 0 ? 'active' : '' ?>" id="<?= $key ?>">
                                <?php //= $model->showData($key); ?>

                                <?= $form->field($model, 'title_' . $key)->textInput(['maxlength' => true]) ?>
                                <?= $form->field($model, 'content_' . $key)->widget(CKEditor::class, [
                                    'editorOptions' => ElFinder::ckeditorOptions('elfinder', [
//                            'allowedContent' => true,
                                        'extraPlugins' => 'image2,widget,oembed,video',
                                        'language' => Yii::$app->language,
                                        'height' => 300,
                                    ]),
                                ]); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-sm-4">

            <div class="box">
                <div class="box-body">
                    <?php
                    if (count($model->categoriesList()) == 1) {
                        echo $form->field($model, 'category_id')->hiddenInput(['value' => array_key_first($model->categoriesList())])->label(false);
                    } else {
                        echo $form->field($model, 'category_id')->dropDownList($model->categoriesList(), ['prompt' => '---']);
                    }
                    ?>
                    <?= $form->field($model, 'photo')->widget(\kartik\file\FileInput::class, [
                        'options' => ['accept' => 'image/*'],
                        'language' => Yii::$app->language,
                        'pluginOptions' => [
                            'showCaption' => false,
                            'showRemove' => false,
                            'showUpload' => false,
                            'browseClass' => 'btn btn-primary btn-block',
                            // 'browseIcon' => ' ',
                            'browseLabel' => 'Рисунок',
                            'layoutTemplates' => [
                                'main1' => '<div class="kv-upload-progress hide"></div>{remove}{cancel}{upload}{browse}{preview}',
                            ],
                            'initialPreview' => [
                                Html::img($model->getThumbFileUrl('photo', 'sm'), ['class' => 'file-preview-image', 'alt' => '', 'title' => '']),
                            ],
                        ],
                    ]);
                    ?>

                    <?php
                    $model->date = $model->date ?: time();
                    echo $form->field($model, 'date')->widget(\yii\jui\DatePicker::class, ['dateFormat' => 'd.MM.yyyy', 'clientOptions' => ['changeYear' => true], 'options' => ['class' => 'form-control']]);
                    ?>

                    <hr>
                    <?= Html::submitButton(Yii::t('cms', 'Save'), ['class' => 'btn btn-success pull-right']) ?>
                </div>
            </div>
        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>
