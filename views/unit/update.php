<?php

use afzalroq\cms\entities\unit\Categories;
use afzalroq\cms\entities\unit\Unit;

/* @var $this yii\web\View */
/* @var $model Blocks */
/* @var $category Categories */

$this->title = Yii::t('unit', 'Update');
$this->params['breadcrumbs'][] = ['label' => Yii::t('unit','Unit'), 'url' => ['index', 'slug' => $category->slug]];
$this->params['breadcrumbs'][] = ['label' => $model->label, 'url' => ['view', 'id' => $model->id, 'slug' => $category->slug]];
$this->params['breadcrumbs'][] = Yii::t('unit', 'Update');
?>
<div class="articles-update">

    <?= $this->render('_form', [
        'model' => $model,
        'category' => $category
    ]) ?>

</div>
