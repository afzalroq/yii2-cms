<?php

/* @var $this yii\web\View */
/* @var $model ArticleCategories */

$this->title = Yii::t('cms', 'Create');
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-categories-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
