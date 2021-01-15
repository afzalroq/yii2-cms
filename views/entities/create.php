<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model afzalroq\cms\entities\Entities */

$this->title = Yii::t('cms', 'Create Entities');
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms', 'Entities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="entities-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
