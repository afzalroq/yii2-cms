<?php

use mihaildev\elfinder\ElFinder;
use sadovojav\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \abdualiym\cms\entities\Pages */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pages-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

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

    <div class="form-group">
        <?= Html::submitButton(Yii::t('cms', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
