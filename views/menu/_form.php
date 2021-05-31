<?php

use afzalroq\cms\assets\MenuAsset;
use afzalroq\cms\entities\Menu;
use afzalroq\cms\entities\MenuType;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

MenuAsset::register($this);

/* @var $this yii\web\View */
/* @var $model Menu */
/* @var $menuType MenuType */
/* @var $form yii\widgets\ActiveForm */
/* @var $action string */

?>

<style>
    .field-menu-types_helper, .field-menu-link {
        display: none;
    }
</style>

<div class="pages-form">
    <?php $form = ActiveForm::begin([
        'action' => $action
    ]); ?>

    <?= $form->field($model, 'menu_type_id')->hiddenInput(['value' => $menuType->id])->label(false) ?>
    <?= $form->field($model, 'type')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'type_helper')->hiddenInput()->label(false) ?>
    <?= $form->errorSummary($model) ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'types')->dropDownList([], [
                'prompt' => Yii::t('cms', 'Choose')
            ]) ?>
            <div class="row">
                <div class="col-sm-12">
                    <?= $form->field($model, 'types_helper')->dropDownList([]) ?>
                </div>
            </div>
            <?= $form->field($model, 'link')->textInput(['placeholder' => 'http://']) ?>
        </div>
        <div class="col-sm-6">
            <div class="row">
                <div class="col-md-12">
                    <?php foreach (Yii::$app->params['cms']['languages'] as $key => $language) : ?>
                        <?= $form->field($model, 'title_' . $key)->textInput(['maxlength' => true, 'data-type' => 'titles']) ?>
                    <?php endforeach; ?>
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
    const [constEmpty,
            constAction,
            constLink,
            constOption,
            constItem,
            constCollection,
            constEntity,
            constEntityItem
        ] = JSON.parse('<?= JSON_encode(Menu::getTypes()) ?>'),

        [collectionList, entityList, optionList] = JSON.parse('<?= JSON_encode($model->COEList()) ?>'),
        typeList = Object.entries(JSON.parse('<?= JSON_encode($model->typesList()) ?>')),
        actionList = Object.entries(JSON.parse('<?= JSON_encode($model->actionsList()) ?>')),
        typeValue = '<?= $model->type ?>',
        typesValue = '<?= $model->types ?>',
        helperValue = '<?= $model->types_helper ?>',
        ajaxUrl = '<?= Url::to(['menu/type']) ?>'

</script>
