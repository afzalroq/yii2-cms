<?php

use afzalroq\cms\entities\unit\Categories;
use afzalroq\cms\entities\unit\TextInput;
use afzalroq\cms\entities\unit\Unit;
use afzalroq\cms\forms\UnitSearch;
use afzalroq\cms\helpers\UnitType;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel UnitSearch */
/* @var $category Categories */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $category->title;
$this->params['breadcrumbs'][] = ['label' => $category->title, 'url' => ['/unit/categories/view', 'id' => $category->id]];
?>
<div class="articles-index">

    <p>
        <?= Html::a(Yii::t('unit', 'Create'), ['create', 'slug' => $category->slug], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('unit', 'Categories'), ['unit-categories/index'], ['class' => 'btn btn-primary']) ?>
    </p>
    
    <div style="overflow: auto; overflow-y: hidden">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                'sort',
                [
                    'attribute' => 'label',
                    'value' => function (Unit $model) use ($category) {
                        return Html::a($model->label, ['view', 'id' => $model->id, 'slug' => $category->slug]);
                    },
                    'format' => 'raw'
                ],
                [
                    'attribute' => 'type',
                    'format' => 'html',
                    'label' => (new Unit())->getAttributeLabel('slug'),
                    'value' => function ($model) {
                        return Html::tag('code', $model->slug, ['class' => 'text-bold']);
                    }
                ],
                [
                    'attribute' => 'type',
                    'value' => function ($model) {
                        return UnitType::name($model->type);
                    }
                ],
                [
                    'attribute' => 'inputValidator',
                    'value' => function ($model) {
                        return TextInput::validatorName($model->inputValidator);
                    }
                ],
                'size',
            ],
        ]); ?>
    </div>
</div>
