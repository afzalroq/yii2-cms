<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model afzalroq\cms\entities\ItemComments */
/* @var $entity \afzalroq\cms\entities\Entities */

?>


<?php
$form = ActiveForm::begin([
    'fieldConfig' => [
        'options' => [
            'enableClientValidation' => false,
            'enableAjaxValidation' => true
        ]
    ]
]);
?>
<div class="box box-default">
    <div class="box-body">
        <?php if($entity->comment_without_login): ?>
            <?php if (\Yii::$app->user->isGuest): ?>
                <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
            <?php else: ?>
                <?= $form->field($model, 'user_id')->hiddenInput(['value' => \Yii::$app->user->identity->id])->label(false) ?>
            <?php endif; ?>
        <?php else: ?>
            <?= $form->field($model, 'user_id')->hiddenInput(['value' => \Yii::$app->user->identity->id])->label(false) ?>
        <?php endif ?>

        <?php if ($entity->use_votes != \afzalroq\cms\entities\Entities::COMMENT_OFF): ?>
            <?=$form->field($model, 'vote')->textInput(['type' => 'number'])?>
        <?php endif; ?>
        <?php if ($entity->use_comments != \afzalroq\cms\entities\Entities::COMMENT_OFF): ?>
            <?=$form->field($model, 'text')->textarea(['rows' => 6])?>
        <?php endif; ?>
    </div>
    <div class="box-footer">
        <div class="form-group">
            <?= Html::submitButton(Yii::t('cms', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>
    </div>
</div>


<?php ActiveForm::end(); ?>
