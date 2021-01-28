<?php

use yii\helpers\Html;
use afzalroq\cms\entities\Menu;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model Menu */

$this->title = Yii::t('cms', 'Create');
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms', 'Menu'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-create">

    <?= $this->render('_form', [
        'model' => $model,
        'action' => Url::to(['menu/create'])
    ]) ?>

</div>
