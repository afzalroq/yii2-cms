<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model abdualiym\cms\entities\Entities */

$this->title = Yii::t('cms', 'Update Entities: {name}', [
    'name' => $model->slug,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms', 'Entities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('cms', 'Update');
?>
<div class="entities-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
