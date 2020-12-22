<?php

use abdualiym\cms\components\FileType;
use abdualiym\cms\entities\Collections;
use abdualiym\cms\entities\Options;
use yii\bootstrap\ToggleButtonGroup;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model Collections */
/* @var $form yii\widgets\ActiveForm */


?>

<?php if(Yii::$app->session->hasFlash('success')): ?>
    <div style="margin:5px 0 0 0;" class="alert alert-success"><?= Yii::$app->session->getFlash('success') ?></div>
<?php endif; ?>
<div class="pages-form">

	<?php $form = ActiveForm::begin(); ?>

	<?= $form->errorSummary($model) ?>

    <div class="box">
        <div class="box-body">
            <div class="row">
                <div class="col-sm-4">
					<?= $form->field($model, 'name_0')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-4">
					<?= $form->field($model, 'name_1')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-4">
					<?= $form->field($model, 'name_2')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-4">
					<?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
                </div>

                <div class="col-sm-4">
					<?= $form->field($model, 'use_in_menu')->dropDownList(Collections::optionUseInMenuList()) ?>
                </div>
                <div class="col-sm-3" style="padding-top: 23px">
					<?= $form->field($model, 'use_parenting')->checkbox() ?>
                </div>
            </div>
        </div>
    </div>

    <div class="box">
        <div class="box-body">
			<?php if(!$model->isNewRecord): ?>
                <div class="row">
                    <div class="col-sm-3">
						<?= $form->field($model, 'option_default_id')->dropDownList(ArrayHelper::map(Options::findAll(['collection_id' => $model->id]), 'id', 'slug'), [
						        'prompt' => ''
                        ]) ?>
                    </div>
                </div>
			<?php endif; ?>
            <div class="row">
                <div class="col-sm-4">
                    <div class="box">
                        <div class="box-body">
							<?= $form->field($model, 'option_file_1')->dropDownList(Collections::optionFileList()) ?>
							<?= $form->field($model, 'option_file_1_label')->textInput() ?>
							<?= $form->field($model, 'file_1_mimeType')->widget(ToggleButtonGroup::class, [
								'type' => 'radio',
								'items' => FileType::MIME_TYPES,
								'labelOptions' => [
									'class' => 'btn btn-default'
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
                <div class="col-sm-4">
                    <div class="box">
                        <div class="box-body">
							<?= $form->field($model, 'option_file_2')->dropDownList(Collections::optionFileList()) ?>
							<?= $form->field($model, 'option_file_2_label')->textInput() ?>
							<?= $form->field($model, 'file_2_mimeType')->widget(ToggleButtonGroup::class, [
								'type' => 'radio',
								'items' => FileType::MIME_TYPES,
								'labelOptions' => [
									'class' => 'btn btn-default'
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
                <div class="col-sm-2">
					<?= $form->field($model, 'option_name')->dropDownList(Collections::optionNameList()) ?>
                </div>
                <div class="col-sm-2">
					<?= $form->field($model, 'option_content')->dropDownList(Collections::optionContentList()) ?>
                </div>
            </div>

        </div>
    </div>

    <div class="form-group">
		<?= Html::submitButton($model->isNewRecord ? Yii::t('cms', 'Create') : Yii::t('cms', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>


	<?php ActiveForm::end(); ?>

</div>
<script>
    document.querySelector('#collections-file_1_mimeType').style.borderColor = 'transparent'
    document.querySelector('#collections-file_2_mimeType').style.borderColor = 'transparent'
</script>