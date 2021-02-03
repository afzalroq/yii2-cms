<?php

use afzalroq\cms\entities\Collections;
use afzalroq\cms\entities\Options;
use afzalroq\cms\widgets\menu\CmsNestable;
use slatiusa\nestable\Nestable;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $collection Collections */

$this->title = Yii::t('cms', 'Options');
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    ._root_ {
        display: none;
    }
</style>
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