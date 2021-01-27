<?php

use yii\helpers\Html;
use afzalroq\cms\entities\Menu;

/* @var $this yii\web\View */
/* @var $model Menu */

$this->title = Yii::t('cms', 'Create Child');
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms', 'Menu'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-create">

    <?= $this->render('_formChild', [
        'model' => $model,
        'root_id' => $root_id
    ]) ?>

</div>
