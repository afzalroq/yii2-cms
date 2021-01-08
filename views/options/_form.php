<?php

use afzalroq\cms\components\FileType;
use afzalroq\cms\entities\Collections;
use afzalroq\cms\entities\Options;
use kartik\file\FileInput;
use kartik\form\ActiveForm;
use mihaildev\elfinder\ElFinder;
use sadovojav\ckeditor\CKEditor;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

//use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model Options */
/* @var $collection Collections */
/* @var $form ActiveForm */

$hasTranslatableAttrs = 0;


?>

<?php if(Yii::$app->session->hasFlash('success')): ?>
    <div style="margin:5px 0 0 0;" class="alert alert-success"><?= Yii::$app->session->getFlash('success') ?></div>
<?php endif; ?>
<div class="pages-form">

	<?php $form = \yii\widgets\ActiveForm::begin(); ?>

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
				if($optionIdList): ?>
                    <div class="col-md-4">
						<?= $form->field($model, 'parent_id')->dropDownList($optionIdList, ['prompt' => 'Please select', 'options' => ['value' => 'none', 'class' => 'prompt', 'label' => 'Select']]) ?>
                    </div>
				<?php endif; ?>
                <div class="col-md-4">
					<?= $form->field($model, 'sort')->textInput(['type' => 'number']) ?>
                </div>
            </div>
            <div class="row">
				<?php if($collection->option_name == Collections::OPTION_NAME_COMMON): ?>
                    <div class="col-md-6">
						<?= $form->field($model, 'name_0')->textInput()->label(Yii::t('cms', 'Title')) ?>
                    </div>
				<?php endif; ?>
				<?php if($collection->option_content == Collections::OPTION_CONTENT_COMMON_TEXTAREA): ?>
                    <div class="col-md-6">
						<?= $form->field($model, 'content_0')->textarea()->label(Yii::t('cms', 'Description')) ?>
                    </div>
				<?php endif; ?>
				<?php if($collection->option_content == Collections::OPTION_CONTENT_COMMON_CKEDITOR): ?>
                    <div class="col-md-12">
						<?= $form->field($model, 'content_0')->widget(CKEditor::class, [
							'editorOptions' => ElFinder::ckeditorOptions('elfinder', [
								'extraPlugins' => 'image2,widget,oembed,video',
								'language' => Yii::$app->language,
								'height' => 300,
							]),
						])->label(Yii::t('cms', 'Description')); ?>
                    </div>
				<?php endif; ?>

				<?php if($collection->option_file_1 == Collections::OPTION_FILE_COMMON): ?>
                    <div class="col-md-6">
						<?php if(FileType::fileMimeType($collection->file_1_mimeType) === FileType::TYPE_IMAGE) : ?>
							<?= $form->field($model, 'file_1_0')->widget(FileInput::class, [
								'options' => ['accept' => FileType::fileAccepts($collection->file_1_mimeType)],
								'language' => Yii::$app->language,
								'pluginOptions' => [
									'showCaption' => false,
									'showRemove' => false,
									'showUpload' => false,
									'browseClass' => 'btn btn-primary btn-block',
									'browseLabel' => 'Рисунок',
									'layoutTemplates' => [
										'main1' => '<div class="kv-upload-progress hide"></div>{remove}{cancel}{upload}{browse}{preview}',
									],
								],
							])->label($collection->option_file_1_label); ?>
						<?php endif; ?>
						<?php if(FileType::fileMimeType($collection->file_1_mimeType) === FileType::TYPE_FILE) : ?>
							<?= $form->field($model, 'file_1_0')->fileInput([
								'accept' => FileType::fileAccepts($collection->file_1_mimeType)
							])->label($collection->option_file_1_label); ?>
						<?php endif; ?>
                    </div>
				<?php endif; ?>

				<?php if($collection->option_file_2 == Collections::OPTION_FILE_COMMON): ?>
                    <div class="col-md-6">
						<?php if(FileType::fileMimeType($collection->file_2_mimeType) === FileType::TYPE_IMAGE) : ?>
							<?= $form->field($model, 'file_2_0')->widget(FileInput::class, [
								'options' => ['accept' => FileType::fileAccepts($collection->file_2_mimeType)],
								'language' => Yii::$app->language,
								'pluginOptions' => [
									'showCaption' => false,
									'showRemove' => false,
									'showUpload' => false,
									'browseClass' => 'btn btn-primary btn-block',
									'browseLabel' => 'Рисунок',
									'layoutTemplates' => [
										'main1' => '<div class="kv-upload-progress hide"></div>{remove}{cancel}{upload}{browse}{preview}',
									],
								],
							])->label($collection->option_file_2_label); ?>
						<?php endif; ?>

						<?php if(FileType::fileMimeType($collection->file_2_mimeType) === FileType::TYPE_FILE) : ?>
							<?= $form->field($model, 'file_2_0')->fileInput([
								'accept' => FileType::fileAccepts($collection->file_2_mimeType)
							])->label($collection->option_file_2_label); ?>
						<?php endif; ?>

                    </div>
				<?php endif; ?>

            </div>
        </div>
    </div>

    <div class="row" id="translatable">
        <div class="col-md-12">
            <hr>
            <div class="box">
                <div class="box-body">
                    <ul class="nav nav-tabs" role="tablist">
						<?php foreach(Yii::$app->params['cms']['languages2'] as $key => $language) : ?>
                            <li role="presentation" <?= $key == 0 ? 'class="active"' : '' ?>>
                                <a href="#<?= $key ?>" aria-controls="<?= $key ?>" role="tab"
                                   data-toggle="tab"><?= $language ?></a>
                            </li>
						<?php endforeach; ?>
                    </ul>
                    <div class="tab-content">
                        <br>
						<?php foreach(Yii::$app->params['cms']['languages2'] as $key => $language) : ?>
                            <div role="tabpanel" class="tab-pane <?= $key == 0 ? 'active' : '' ?>" id="<?= $key ?>">

								<?php if($collection->option_name && $collection->option_name == Collections::OPTION_NAME_TRANSLATABLE): $hasTranslatableAttrs = 1 ?>
									<?= $form->field($model, 'name_' . $key)->textInput(['maxlength' => true]) ?>
								<?php endif; ?>
								<?php if($collection->option_content): ?>
									<?php if($collection->option_content == Collections::OPTION_CONTENT_TRANSLATABLE_TEXTAREA): $hasTranslatableAttrs = 1 ?>
										<?= $form->field($model, 'content_' . $key)->textarea(); ?>
									<?php endif; ?>
									<?php if($collection->option_content == Collections::OPTION_CONTENT_TRANSLATABLE_CKEDITOR): $hasTranslatableAttrs = 1 ?>
										<?= $form->field($model, 'content_' . $key)->widget(CKEditor::class, [
											'editorOptions' => ElFinder::ckeditorOptions('elfinder', [
												'extraPlugins' => 'image2,widget,oembed,video',
												'language' => Yii::$app->language,
												'height' => 300,
											]),
										]); ?>
									<?php endif; ?>
								<?php endif; ?>
                                <div class="row">
									<?php if($collection->option_file_1 == Collections::OPTION_FILE_TRANSLATABLE): $hasTranslatableAttrs = 1 ?>
                                        <div class="col-md-6">
											<?php if(FileType::fileMimeType($collection->file_1_mimeType) === FileType::TYPE_IMAGE) : ?>
												<?= $form->field($model, 'file_1_' . $key)->widget(FileInput::class, [
													'options' => ['accept' => FileType::fileAccepts($collection->file_1_mimeType)],
													'language' => Yii::$app->language,
													'pluginOptions' => [
														'showCaption' => false,
														'showRemove' => false,
														'showUpload' => false,
														'browseClass' => 'btn btn-primary btn-block',
														'browseLabel' => 'Рисунок',
														'layoutTemplates' => [
															'main1' => '<div class="kv-upload-progress hide"></div>{remove}{cancel}{upload}{browse}{preview}',
														],
													],
												])->label($collection->option_file_1_label); ?>
											<?php endif; ?>
											<?php if(FileType::fileMimeType($collection->file_1_mimeType) === FileType::TYPE_FILE): ?>
												<?= $form->field($model, 'file_1_' . $key)->fileInput([
													'accept' => FileType::fileAccepts($collection->file_1_mimeType)
												])->label($collection->option_file_1_label); ?>
											<?php endif; ?>
                                        </div>
									<?php endif; ?>
									<?php if($collection->option_file_2 == Collections::OPTION_FILE_TRANSLATABLE): $hasTranslatableAttrs = 1 ?>
                                        <div class="col-md-6">
											<?php if(FileType::fileMimeType($collection->file_2_mimeType) === FileType::TYPE_IMAGE) : ?>
												<?= $form->field($model, 'file_2_' . $key)->widget(FileInput::class, [
													'options' => ['accept' => FileType::fileAccepts($collection->file_2_mimeType)],
													'language' => Yii::$app->language,
													'pluginOptions' => [
														'showCaption' => false,
														'showRemove' => false,
														'showUpload' => false,
														'browseClass' => 'btn btn-primary btn-block',
														'browseLabel' => 'Рисунок',
														'layoutTemplates' => [
															'main1' => '<div class="kv-upload-progress hide"></div>{remove}{cancel}{upload}{browse}{preview}',
														],
													],
												])->label($collection->option_file_2_label); ?>
											<?php endif; ?>
											<?php if(FileType::fileMimeType($collection->file_2_mimeType) === FileType::TYPE_FILE): ?>
												<?= $form->field($model, 'file_2_' . $key)->fileInput([
													'accept' => FileType::fileAccepts($collection->file_2_mimeType)
												])->label($collection->option_file_2_label); ?>
											<?php endif; ?>
                                        </div>
									<?php endif; ?>

                                </div>
                            </div>
						<?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if ($collection->use_seo > 0): ?>
        <div class="row">
            <div class="col-md-12">
                <hr>
                <div class="box">
                    <div class="box-body">
                        <?php if ($collection->use_seo == Collections::SEO_TRANSLATABLE ): ?>
                            <ul class="nav nav-tabs" role="tablist">
                                <?php foreach(Yii::$app->params['cms']['languages2'] as $key => $language) : ?>
                                    <li role="presentation" <?= $key == 0 ? 'class="active"' : '' ?>>
                                        <a href="#<?= $key ?>S" aria-controls="<?= $key ?>S" role="tab"
                                           data-toggle="tab"><?= $language ?></a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            <div class="tab-content">
                                <br>
                                <?php foreach(Yii::$app->params['cms']['languages2'] as $key => $language) : ?>
                                    <div role="tabpanel" class="tab-pane <?= $key == 0 ? 'active' : '' ?>" id="<?= $key ?>S">

                                        <?= $form->field($model,'meta_title_'.$key)->textInput() ?>
                                        <?= $form->field($model,'meta_keyword_'.$key)->textInput() ?>
                                        <?= $form->field($model,'meta_des_'.$key)->textInput() ?>

                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else:?>
                            <?= $form->field($model,'meta_title_0')->textInput() ?>
                            <?= $form->field($model,'meta_keyword_0')->textInput() ?>
                            <?= $form->field($model,'meta_des_0')->textInput() ?>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="form-group">
		<?= Html::submitButton($model->isNewRecord ? Yii::t('cms', 'Create') : Yii::t('cms', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
	<?php \yii\widgets\ActiveForm::end(); ?>
    <script>
        if (!<?= $hasTranslatableAttrs?>)
            document.querySelector('#translatable').innerHTML = ''
    </script>
</div>
