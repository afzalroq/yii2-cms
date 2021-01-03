<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model abdualiym\cms\forms\EntitiesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="entities-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'slug') ?>

    <?= $form->field($model, 'text_1') ?>

    <?= $form->field($model, 'text_2') ?>

    <?= $form->field($model, 'text_3') ?>

    <?php // echo $form->field($model, 'text_4') ?>

    <?php // echo $form->field($model, 'text_5') ?>

    <?php // echo $form->field($model, 'text_6') ?>

    <?php // echo $form->field($model, 'text_7') ?>

    <?php // echo $form->field($model, 'text_label_1') ?>

    <?php // echo $form->field($model, 'text_label_2') ?>

    <?php // echo $form->field($model, 'text_label_3') ?>

    <?php // echo $form->field($model, 'text_label_4') ?>

    <?php // echo $form->field($model, 'text_label_5') ?>

    <?php // echo $form->field($model, 'text_label_6') ?>

    <?php // echo $form->field($model, 'text_label_7') ?>

    <?php // echo $form->field($model, 'file_1') ?>

    <?php // echo $form->field($model, 'file_2') ?>

    <?php // echo $form->field($model, 'file_3') ?>

    <?php // echo $form->field($model, 'file_label_1') ?>

    <?php // echo $form->field($model, 'file_label_2') ?>

    <?php // echo $form->field($model, 'file_label_3') ?>

    <?php // echo $form->field($model, 'use_date') ?>

    <?php // echo $form->field($model, 'use_status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('cms', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('cms', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
