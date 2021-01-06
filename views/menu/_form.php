<?php

use afzalroq\cms\entities\Collections;
use afzalroq\cms\entities\Entities;
use afzalroq\cms\entities\Menu;
use afzalroq\cms\entities\Options;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model Menu */
/* @var $form yii\widgets\ActiveForm */


$entities = [];
$collections = [];
$options = [];

/** @var Collections $collection */
foreach(Collections::find()->all() as $collection)
	switch($collection->use_in_menu) {
		case Collections::USE_IN_MENU_OPTIONS:
			$collections[] = [
				'id' => $collection->id,
				'name' => $collection->name_0
			];
			break;
		case Collections::USE_IN_MENU_ITEMS:
			foreach(Options::findAll(['collection_id' => $collection->id]) as $option)
				$options[] = [
					'id' => $option->id,
					'name' => $option->name_0
				];
			break;
		default:
			break;
	}

/** @var Entities $entity */
foreach(Entities::find()->all() as $entity)
	if($entity->use_in_menu)
		$entities[] = [
			'id' => $entity->id,
			'name' => $entity->name_0
		];
?>
    <style>
        .field-menu-types_helper, .field-menu-link {
            display: none;
        }
    </style>
<?php if(Yii::$app->session->hasFlash('success')): ?>
    <div style="margin:5px 0 0 0;"
         class="alert alert-success"><?= Yii::$app->session->getFlash('success') ?></div><?php endif; ?>
    <div class="pages-form">
		<?php $form = ActiveForm::begin(); ?>
		<?= $form->field($model, 'type')->hiddenInput()->label(false) ?>
		<?= $form->field($model, 'type_helper')->hiddenInput()->label(false) ?>
		<?= $form->errorSummary($model) ?>

        <div class="row">
            <div class="col-sm-6">
				<?= $form->field($model, 'types')->dropDownList([], [
					'prompt' => Yii::t('cms', 'Choose')
				]) ?>
                <div class="row">
					<?php if(!$model->isNewRecord): ?>
                        <div class="col-sm-6">
							<?= $form->field($model, 'parent_id')->dropDownList([0 => Yii::t('cms', 'No parent')] + ArrayHelper::map(Menu::find()->all(), 'id', 'title_0')) ?>
                        </div>
					<?php endif; ?>
                    <div class="col-sm-6">
						<?= $form->field($model, 'sort')->dropDownList([1 => 1, 2, 3, 4, 5, 6, 7, 8, 9, 10], [
							'value' => $model->isNewRecord ? $model->getMaxSort() : $model->sort
						]) ?>
                    </div>
                    <div class="col-sm-<?= ($model->isNewRecord) ? 6 : 12 ?>">
						<?= $form->field($model, 'types_helper')->dropDownList([]) ?>
                    </div>
                </div>
				<?= $form->field($model, 'link')->textInput(['placeholder' => 'http://']) ?>
            </div>
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-md-12">
						<?php foreach(Yii::$app->params['cms']['languages2'] as $key => $language) : ?>
							<?= $form->field($model, 'title_' . $key)->textInput(['maxlength' => true, 'data-type' => 'titles']) ?>
						<?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
		<?= Html::submitButton($model->isNewRecord ? Yii::t('cms', 'Create') : Yii::t('cms', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end(); ?>

    <script>
        const constEmpty = '<?= Menu::TYPE_EMPTY ?>',
            constAction = '<?= Menu::TYPE_ACTION ?>',
            constLink = '<?= Menu::TYPE_LINK ?>',
            constOption = '<?= Menu::TYPE_OPTION ?>',
            constItem = '<?= Menu::TYPE_ITEM ?>',
            constEntityItem = '<?= Menu::TYPE_ENTITY_ITEM ?>',

            typeValue = '<?= $model->type ?>',
            typesValue = '<?= $model->types ?>',
            helperValue = '<?= $model->types_helper ?>',

            collectionList = JSON.parse('<?= JSON_encode($collections) ?>'),
            entityList = JSON.parse('<?= JSON_encode($entities) ?>'),
            optionList = JSON.parse('<?= JSON_encode($options) ?>'),
            typeList = Object.entries(JSON.parse('<?= JSON_encode($model->typesList()) ?>')),
            actionList = Object.entries(JSON.parse('<?= JSON_encode($model->actionsList()) ?>')),

            ajaxUrl = '<?= Url::to(['menu/type']) ?>'
    </script>
<?php
$script = <<< JS
$(document).ready(function () {
    const titles = document.querySelectorAll('[data-type="titles"]'),
        helperForm = $('.field-menu-types_helper'),
        typeHelper = $('#menu-type_helper'),
        helper = $('#menu-types_helper'),
        types = $('#menu-types'),
        type = $('#menu-type'),
        linkForm = $('.field-menu-link')
    let options = '', key, value

    //region init
    typeList.forEach((type) => options += '<option value=type_' + type[0] + '>' + type[1] + '</option>')
    actionList.forEach((action) => options += '<option value=action_' + action[0] + '>' + action[1] + '</option>')
    collectionList.forEach((collection) => options += '<option value=collection_' + collection.id + '>' + collection.name + '</option>')
    optionList.forEach((option) => options += '<option value=option_' + option.id + '>' + option.name + '</option>')
    entityList.forEach((entity) => options += '<option value=entity_' + entity.id + '>' + entity.name + '</option>')
    types.html(options)

    hideAll()
    switch (typeValue) {
        case constEmpty:
        case constAction:
            types.val(typesValue)
            break
        case constLink:
            types.val(typesValue)
            linkForm.slideDown()
            break
        case constOption:
        case constItem:
        case constEntityItem:
            initEntityOptionItem()
            break
        default:
            types.val('type_' + constEmpty)
            type.val(constEmpty)
            typeHelper.val(null)
    }
    //endregion

    //region bindings
    helper.on('change', function () {
        let optionText = $('#menu-types_helper').find(":selected").text()
        setNames(optionText)
        typeHelper.val(this.value)
    })
    types.on('change', function () {
        hideAll()
        key = this.value.split('_')[0]
        value = this.value.split('_')[1]

        switch (key) {
            case 'type':
                typeControl(value, key);
                break
            case 'action':
                type.val(constAction)
                typeHelper.val(value)
                setNames(types.find(":selected").text())
                break
            case 'collection':
                type.val(constOption)
                postAjax(value, key)
                break
            case 'option':
                type.val(constItem)
                postAjax(value, key)
                break
            case 'entity':
                type.val(constEntityItem)
                postAjax(value, key)
                break
        }
    })
    //endregion

    
    function initEntityOptionItem() {
        types.val(typesValue)
        helperForm.slideDown()
        helper.html(helperValue)
    }
    
    function postAjax(id, type) {
        $.ajax(ajaxUrl, {
            data: {
                id: id,
                type: type
            },
            method: 'POST',
            success: function (data) {
                console.log('success')
                console.log(data)

                if (data.status && data.data.length !== 0) {
                    options = '';
                    data.data.forEach((item) => options += '<option value=' + item.id + '>' + item.name + '</option>')
                    console.log(options)
                    
                    //init type_helper and names
                    setNames(data.data[0].name)
                    typeHelper.val(data.data[0].id)
                    //

                    helper.html(options)
                    helperForm.slideDown()
                } else {
                    typeHelper.val('')
                    setNames('')
                    helper.html('')
                    helperForm.hide()
                }
            }
        })
    }

    function typeControl(_type) {
        type.val(_type)
        setNames('')
        typeHelper.val('')
        if (!_type || _type === constEmpty)
            hideAll();

        if (_type === constLink) {
            hideAll();
            linkForm.slideDown();
        }
    }

    function hideAll() {
        linkForm.hide();
        helperForm.hide();
    }

    function setNames(text) {
        for (title of titles) {
            title.value = text
        }
    }

    
});
JS;
$this->registerJs($script, View::POS_READY);
