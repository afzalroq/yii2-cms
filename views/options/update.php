<?php

use afzalroq\cms\entities\Collections;
use afzalroq\cms\entities\Menu;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model Menu */
/* @var $collection Collections */

$this->title = Yii::t('cms', 'Update');
$this->params['breadcrumbs'][] = ['label' => $collection->{"name_" . Yii::$app->params['l'][Yii::$app->language]}, 'url' => ['index', 'slug' => $collection->slug]];
$this->params['breadcrumbs'][] = ['label' => $model->{'name_' . Yii::$app->params['l'][Yii::$app->language]}, 'url' => ['view', 'id' => $model->id, 'slug' => $collection->slug]];
$this->params['breadcrumbs'][] = Yii::t('cms', 'Update');
?>
<div class="menu-update">

    <?= $this->render('_form', [
        'model' => $model,
        'collection' => $collection,
        'action' => Url::to(['options/update', 'id' => $model->id, 'slug' => $collection->slug])
    ]) ?>

</div>
