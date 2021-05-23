<?php

/* @var $this yii\web\View */
/* @var $model afzalroq\cms\entities\Entities */
/* @var $cam afzalroq\cms\entities\CaE */

/* @var $unassignedOptions afzalroq\cms\entities\Collections[] */

use afzalroq\cms\entities\CaM;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use afzalroq\cms\assets\MenuTypeAsset;


$this->title = $model->slug;

MenuTypeAsset::register($this);

?>
<div class="entities-view">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($cam) ?>

    <?= Html::activeHiddenInput($cam, 'menu_type_id', ['value' => $model->id,'id' => 'menuType']) ?>

    <div class="box">
        <div class="box-body">
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($cam, 'collection_id')->dropDownList(ArrayHelper::map(CaM::collectionsList(), 'id', 'slug'), ['id' => 'collectionsId', 'prompt' => Yii::t('cms', 'Choose')]) ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($cam, 'option_id')->dropDownList([]) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('cms', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>
