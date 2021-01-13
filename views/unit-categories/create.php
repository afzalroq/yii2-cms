<?php

use afzalroq\cms\entities\unit\Categories;

/* @var $this yii\web\View */
/* @var $model Categories */

$this->title = Yii::t('unit', 'Create');
$this->params['breadcrumbs'][] = ['label' => Yii::t('unit', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-categories-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
