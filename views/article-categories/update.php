<?php
use abdualiym\cms\entities\ArticleCategories;

/* @var $this yii\web\View */
/* @var $model ArticleCategories */

$this->title = Yii::t('cms', 'Update');
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms', 'Article Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title_0, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('cms', 'Update');
?>
<div class="article-categories-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
