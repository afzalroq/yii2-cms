<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model afzalroq\cms\entities\ItemComments */


$this->title = \yii\helpers\StringHelper::truncate($item->text_1_0, 40, '...');
$this->params['breadcrumbs'][] = ['label' => $entity->{"name_" . Yii::$app->params['l'][Yii::$app->language]}, 'url' => ['cms/item/index', 'slug' => $entity->slug]];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/cms/items/view', 'id' => $item->id, 'slug' => $entity->slug]];
$this->title = Yii::t('cms', 'Update');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="entities-create">

    <?= $this->render('_form', [
        'model' => $model,
        'entity' => $entity
    ]) ?>

</div>
