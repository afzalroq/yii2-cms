<?php

use afzalroq\cms\entities\Collections;
use afzalroq\cms\entities\Options;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model Options */
/* @var $collection Collections */
/* @var $root_id integer */

$this->title = Yii::t('cms', 'Create');
$this->params['breadcrumbs'][] = ['label' => $collection->{"name_" . Yii::$app->params['l'][Yii::$app->language]}, 'url' => ['index', 'slug' => $collection->slug]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-create">

    <?= $this->render('_form', [
        'model' => $model,
        'collection' => $collection,
        'action' => Url::to(['options/add-child', 'root_id' => $root_id, 'slug' => $collection->slug])
    ]) ?>
</div>
