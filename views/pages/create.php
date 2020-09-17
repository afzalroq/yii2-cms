<?php

/* @var $this yii\web\View */
/* @var $model \abdualiym\cms\entities\Pages */

$this->title = Yii::t('cms', 'Create');
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms', 'Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pages-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
