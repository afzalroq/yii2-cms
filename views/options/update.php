<?php

use afzalroq\cms\entities\Menu;

/* @var $this yii\web\View */
/* @var $model Menu */

$this->title = Yii::t('cms', 'Update');
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms', 'Options'), 'url' => ['index', 'slug' => $collection->slug]];
$this->params['breadcrumbs'][] = ['label' => $model->name_0, 'url' => ['view', 'id' => $model->id, 'slug' => $collection->slug]];
$this->params['breadcrumbs'][] = Yii::t('cms', 'Update');
?>
<div class="menu-update">

    <?= $this->render('_form', [
        'model' => $model,
        'collection' => $collection
    ]) ?>

</div>
