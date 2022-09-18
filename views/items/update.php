<?php

/* @var $this yii\web\View */
/* @var $model afzalroq\cms\entities\Items */
/* @var $entity \afzalroq\cms\entities\Entities */

$this->title = \yii\helpers\StringHelper::truncate($model->{'text_1_' . Yii::$app->params['l'][Yii::$app->language]},45,'...');
$this->params['breadcrumbs'][] = ['label' => $entity->{"name_" . Yii::$app->params['l'][Yii::$app->language]}, 'url' => ['index', 'slug' => $entity->slug]];
$this->params['breadcrumbs'][] = ['label' => $model->{'text_1_' . Yii::$app->params['l'][Yii::$app->language]}, 'url' => ['view', 'id' => $model->id, 'slug' => $entity->slug]];
$this->params['breadcrumbs'][] = Yii::t('cms', 'Update');
?>
<div class="items-update">

    <?= $this->render('_form', [
        'model' => $model,
        'entity' => $entity
    ]) ?>

</div>
