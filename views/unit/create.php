<?php

use afzalroq\cms\entities\unit\Categories;
use afzalroq\cms\entities\unit\Unit;

/* @var $this yii\web\View */
/* @var $model Unit */
/* @var $category Categories */

$this->title = Yii::t('unit', 'Create');
$this->params['breadcrumbs'][] = ['label' => $category->title, 'url' => ['index', 'slug' => $category->slug]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="articles-create">

    <?= $this->render('_form', [
        'model' => $model,
        'category' => $category
    ]) ?>

</div>
