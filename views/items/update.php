<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model abdualiym\cms\entities\Items */
/* @var $entity \abdualiym\cms\entities\Entities */

$this->title = Yii::t('cms', 'Update Items: {name}', [
    'name' => $model->slug,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms', 'Items'), 'url' => ['index', 'slug' => $entity->slug]];
$this->params['breadcrumbs'][] = ['label' => $model->slug, 'url' => ['view', 'id' => $model->id, 'slug' => $entity->slug]];
$this->params['breadcrumbs'][] = Yii::t('cms', 'Update');
?>
<div class="items-update">

    <?= $this->render('_form', [
        'model' => $model,
        'entity' => $entity
    ]) ?>

</div>
