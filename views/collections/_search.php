<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model abdualiym\cms\forms\CollectionsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="collections-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name_0') ?>

    <?= $form->field($model, 'name_1') ?>

    <?= $form->field($model, 'name_2') ?>

    <?= $form->field($model, 'name_3') ?>

    <?php // echo $form->field($model, 'name_4') ?>

    <?php // echo $form->field($model, 'slug') ?>

    <?php // echo $form->field($model, 'use_in_menu') ?>

    <?php // echo $form->field($model, 'use_parenting') ?>

    <?php // echo $form->field($model, 'option_file_1') ?>

    <?php // echo $form->field($model, 'option_file_2') ?>

    <?php // echo $form->field($model, 'option_file_1_label') ?>

    <?php // echo $form->field($model, 'option_file_2_label') ?>

    <?php // echo $form->field($model, 'option_file_1_validator') ?>

    <?php // echo $form->field($model, 'option_file_2_validator') ?>

    <?php // echo $form->field($model, 'option_name') ?>

    <?php // echo $form->field($model, 'option_content') ?>

    <?php // echo $form->field($model, 'option_default_id') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('cms', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('cms', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
