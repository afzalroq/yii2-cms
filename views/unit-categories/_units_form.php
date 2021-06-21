<?php

use afzalroq\cms\entities\unit\Unit;
use afzalroq\cms\helpers\UnitType;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;
use afzalroq\cms\entities\unit\Categories;

/* @var $this View */
/* @var $units Unit */
/* @var $model Categories */
/* @var $form ActiveForm */
?>

<div class="box">
    <div class="box-body">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <?= $form->errorSummary($units) ?>
        <div class="row">
            <?php
            foreach ($units as $unit) {
                foreach (Yii::$app->params['cms']['languages'] as $key => $language) {
                    if (in_array($unit->type, [UnitType::TEXT_COMMON, UnitType::STRING_COMMON, UnitType::IMAGE_COMMON, UnitType::FILE_COMMON, UnitType::INPUT_COMMON])) {
                        echo '<div class="col-sm-' . $unit->size . '">' . ($unit->getModelByType())->getFormField($form) . '</div>';
                        break;
                    }
                    if (!in_array($unit->type, [UnitType::TEXT_COMMON, UnitType::STRING_COMMON, UnitType::IMAGE_COMMON, UnitType::FILE_COMMON, UnitType::INPUT_COMMON])) {
                        echo '<div class="col-sm-' . $unit->size . '">' . ($unit->getModelByType())->getFormField($form, $key, $language) . '</div>';
                    }
                }
            }
            ?>
        </div>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('unit', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
