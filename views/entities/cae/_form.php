<?php

/* @var $this yii\web\View */
/* @var $model afzalroq\cms\entities\Entities */
/* @var $cae afzalroq\cms\entities\CaE */
/* @var $unassignedCollections afzalroq\cms\entities\Collections[] */

use afzalroq\cms\entities\CaE;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="entities-view">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($cae) ?>

    <?= Html::activeHiddenInput($cae, 'entity_id', ['value' => $model->id]) ?>

    <div class="box">
        <div class="box-body">
            <div class="row">
                <div class="col-sm-3">
                    <?= $form->field($cae, 'collection_id')->dropDownList(ArrayHelper::map($unassignedCollections, 'id', 'slug')) ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($cae, 'type')->dropDownList(CaE::typeList()) ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($cae, 'sort')->textInput(['type' => 'number']) ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($cae, 'size')->textInput(['type' => 'number']) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('cms', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>
