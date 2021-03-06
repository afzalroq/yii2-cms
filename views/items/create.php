<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model afzalroq\cms\entities\Items */
/* @var $model afzalroq\cms\entities\Items */
/* @var $entity \afzalroq\cms\entities\Entities */

$this->title = Yii::t('cms', 'Create');
$this->params['breadcrumbs'][] = ['label' => $entity->{"name_" . Yii::$app->params['l'][Yii::$app->language]}, 'url' => ['index', 'slug' => $entity->slug]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="items-create">

    <?= $this->render('_form', [
        'model' => $model,
        'entity' => $entity
    ]) ?>

</div>
