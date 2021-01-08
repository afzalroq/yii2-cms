<?php

use yii\helpers\Html;
use afzalroq\cms\entities\Menu;

/* @var $this yii\web\View */
/* @var $model \afzalroq\cms\entities\Options */
/* @var $collection \afzalroq\cms\entities\Collections */

$this->title = Yii::t('cms', 'Create');
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms', 'Options'), 'url' => ['index', 'slug' => $collection->slug]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-create">

    <?= $this->render('_form', [
        'model' => $model,
        'collection' => $collection
    ]) ?>
</div>
