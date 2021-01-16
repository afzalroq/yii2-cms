<?php

use afzalroq\cms\entities\unit\Categories;
use afzalroq\cms\entities\unit\Unit;

/* @var $this yii\web\View */
/* @var $model Categories */
/* @var $units Unit */

$this->title = $model->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-categories-create">

    <?= $this->render('_units_form', [
        'model' => $model,
        'units' => $units,
    ]) ?>

</div>
