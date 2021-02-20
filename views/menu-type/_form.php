<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model afzalroq\cms\entities\MenuType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-type-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
        </div>
        <?php foreach (Yii::$app->params['cms']['languages'] as $key => $language) : ?>
            <div class="col-sm-3">
                <?= $form->field($model, 'name_' . $key)->textInput(['maxlength' => true]) ?>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('cms', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
