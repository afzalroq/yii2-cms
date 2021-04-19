<?php

/* @var $this yii\web\View */

use mihaildev\elfinder\ElFinder;

$this->title = Yii::t('cms','File');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="file-index">

    <?= ElFinder::widget([
        'frameOptions' => ['style' => 'width: 100%; height: 640px; border: 0;']
    ]); ?>

</div>