<?php

use afzalroq\cms\entities\Collections;
use richardfan\sortable\SortableGridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel afzalroq\cms\forms\CollectionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $collection Collections */

$this->title                   = $collection->{"name_" . Yii::$app->params['l'][Yii::$app->language]};
$this->params['breadcrumbs'][] = $this->title;

$curLang  = Yii::$app->params['l-name'][Yii::$app->language];
$firstKey = array_key_first(Yii::$app->params['cms']['languages']);
$name     = 'name_' . ($collection->option_name === Collections::OPTION_NAME_COMMON ? '0' : $firstKey);
?>
<div class="collections-index">

  <p>
      <?= Html::a(Yii::t('cms', 'Create'), ['create', 'slug' => $collection->slug], ['class' => 'btn btn-success']) ?>
  </p>

  <div style="overflow: auto; overflow-y: hidden">
      <?= SortableGridView::widget([
          'dataProvider' => $dataProvider,
          'filterModel'  => $searchModel,
          'sortUrl'      => Url::to(['sortItem']),
          'columns'      => [
              [
                  'content'        => function () {
                      return "<span class='glyphicon glyphicon-resize-vertical'></span>";
                  },
                  'contentOptions' => ['style' => 'cursor:move;', 'class' => 'moveItem'],
              ],
              ['class' => 'yii\grid\SerialColumn'],
              [
                  'attribute' => $name,
                  'value'     => function ($model) use ($name, $collection) {
                      return Html::a('<i class="fa fa-edit"></i> ' . $model->$name, [
                          '/cms/options/update',
                          'id'   => $model->id,
                          'slug' => $collection->slug,
                      ]);
                  },
//                    'label' => $entity->text_1_label . ' (' . $curLang . ')',
                  'format'    => 'html',
              ],
              'slug',
              'created_at:datetime',
          ],
      ]); ?>
  </div>
</div>
