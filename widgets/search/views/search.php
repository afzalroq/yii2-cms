<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="search-block">
    <?php $form = ActiveForm::begin(['action' => ['/search'], 'method' => 'get']); ?>
    <?= $form->field($searchModel, 'search', ['options' => ['placeholder' => Yii::t('cms', 'Search on site')]])->label(false) ?>
    <?= Html::input('submit', '', Yii::t('cms', 'Search'), ['class' => 'search-btn']) ?>
    <?php ActiveForm::end(); ?>
</div>