<?php

use afzalroq\cms\entities\Menu;
use afzalroq\cms\entities\MenuType;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model Menu */
/* @var $menuType MenuType */

$this->title = Yii::t('cms', 'Update');
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms', 'Menu'), 'url' => ['index', 'slug' => $menuType->slug]];
$this->params['breadcrumbs'][] = ['label' => $model->title_1, 'url' => ['view', 'id' => $model->id, 'slug' => $menuType->slug]];
$this->params['breadcrumbs'][] = Yii::t('cms', 'Update');
?>
<div class="menu-update">

    <?= $this->render('_form', [
        'model' => $model,
        'menuType' => $menuType,
        'action' => Url::to(['menu/update', 'id' => $model->id, 'slug' => $menuType->slug])
    ]) ?>

</div>
