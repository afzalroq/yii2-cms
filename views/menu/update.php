<?php

use abdualiym\cms\entities\Menu;

/* @var $this yii\web\View */
/* @var $model Menu */

$this->title = Yii::t('cms', 'Update');
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms', 'Menu'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title_0, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('cms', 'Update');
?>
<div class="menu-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
