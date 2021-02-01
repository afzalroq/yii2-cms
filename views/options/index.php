<?php

use afzalroq\cms\entities\Options;
use afzalroq\cms\widgets\menu\CmsNestable;
use slatiusa\nestable\Nestable;
use yii\grid\GridView;
use yii\helpers\Html;
use afzalroq\cms\entities\Collections;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $searchModel afzalroq\cms\forms\CollectionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $collection Collections */



$script = <<< JS
    $(document).ready(function () {
        $('._root_').hide().siblings('[data-action="collapse"]').hide()
    })
JS;
$this->registerJs($script, View::POS_READY);

$this->title = Yii::t('cms', 'Options');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="collections-index">

    <p>
        <?= Html::a(Yii::t('cms', 'Create'), ['create', 'slug' => $collection->slug], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="row">
        <div class="col-sm-8">
            <?= CmsNestable::widget([
                'type' => Nestable::TYPE_WITH_HANDLE,
                'query' => Options::find()->where(['collection_id' => $collection->id]),
                'slug' => $collection->slug,
                'entity' => 'options',
                'modelOptions' => [
                    'name' => 'name_0'
                ],
                'pluginEvents' => [
                    'change' => 'function(e) {}',
                ],
                'pluginOptions' => [
                    'maxDepth' => 10,
                ],
            ]); ?>
        </div>
    </div>

</div>