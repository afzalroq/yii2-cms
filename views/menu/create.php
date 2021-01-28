<?php

use afzalroq\cms\entities\Menu;
use afzalroq\cms\entities\MenuType;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model Menu */
/* @var $menuType MenuType */


$this->title = Yii::t('cms', 'Create');
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms', 'Menu'), 'url' => ['index', 'slug' => $menuType->slug]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-create">

    <?= $this->render('_form', [
        'model' => $model,
        'menuType' => $menuType,
        'action' => Url::to(['menu/create', 'slug' => $menuType->slug])
    ]) ?>

</div>
