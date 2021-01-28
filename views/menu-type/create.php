<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model afzalroq\cms\entities\MenuType */

$this->title = Yii::t('cms', 'Create Menu Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms', 'Menu Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
