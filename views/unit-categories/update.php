<?php
use afzalroq\cms\entities\unit\Categories;

/* @var $this yii\web\View */
/* @var $model Categories */

$this->title = Yii::t('unit', 'Update');
$this->params['breadcrumbs'][] = ['label' => Yii::t('unit', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('unit', 'Update');
?>
<div class="article-categories-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
