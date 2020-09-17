<?php

use abdualiym\cms\entities\Articles;

/* @var $this yii\web\View */
/* @var $model Articles */

$this->title = Yii::t('cms', 'Update');
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms', 'Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title_0, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('cms', 'Update');
?>
<div class="articles-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
