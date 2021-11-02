<?php

/* @var $this yii\web\View */
/* @var $model afzalroq\cms\entities\Entities */
/* @var $cae afzalroq\cms\entities\CaE */
/* @var $unassignedCollections afzalroq\cms\entities\Collections[] */

$this->title = '"C & E" ' . Yii::t('cms', 'Create');
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms', 'Entities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->{'name_' . Yii::$app->params['l'][Yii::$app->language]}, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cae-create">

    <?= $this->render('_form', [
        'model' => $model,
        'cae' => $cae,
        'unassignedCollections' => $unassignedCollections
    ]) ?>

</div>
