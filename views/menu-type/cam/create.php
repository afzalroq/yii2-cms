<?php

/* @var $this yii\web\View */
/* @var $model afzalroq\cms\entities\Entities */
/* @var $cae afzalroq\cms\entities\CaE */
/* @var $unassignedCollections afzalroq\cms\entities\Collections[] */


$this->title = Yii::t('cms', 'Create CaE');


$this->params['breadcrumbs'][] = ['label' => Yii::t('cms', 'Entities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->slug, 'url' => ['view', 'id' => $model->id]];

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cae-create">


	<?= $this->render('_form', [
		'model' => $model,
		'cam' => $cam,

	]) ?>

</div>
