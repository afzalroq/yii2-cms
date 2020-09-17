<?php

use abdualiym\cms\entities\Articles;

/* @var $this yii\web\View */
/* @var $model Articles */

$this->title = Yii::t('cms', 'Create');
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms', 'Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="articles-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
