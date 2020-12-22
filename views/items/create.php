<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model abdualiym\cms\entities\Items */
/* @var $entity \abdualiym\cms\entities\Entities */

$this->title = Yii::t('cms', 'Create');
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms', 'Items'), 'url' => ['index', 'slug' => $entity->slug]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="items-create">

    <?= $this->render('_form', [
        'model' => $model,
        'entity' => $entity
    ]) ?>

</div>
