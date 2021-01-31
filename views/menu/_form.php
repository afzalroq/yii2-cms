<?php

use afzalroq\cms\entities\Collections;
use afzalroq\cms\entities\Entities;
use afzalroq\cms\entities\Menu;
use afzalroq\cms\entities\MenuType;
use afzalroq\cms\entities\Options;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JqueryAsset;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model Menu */
/* @var $menuType MenuType */
/* @var $form yii\widgets\ActiveForm */
/* @var $action string */

$entities = [];
$collections = [];
$options = [];

/** @var Collections $collection */
foreach (Collections::find()->all() as $collection)
    switch ($collection->use_in_menu) {
        case Collections::USE_IN_MENU_OPTIONS:
            $collections[] = [
                'id' => $collection->id,
                'name' => $collection->name_0
            ];
            break;
        case Collections::USE_IN_MENU_ITEMS:
            foreach (Options::findAll(['collection_id' => $collection->id]) as $option)
                $options[] = [
                    'id' => $option->id,
                    'name' => $option->slug
                ];
            break;
        default:
            break;
    }

/** @var Entities $entity */
foreach (Entities::find()->all() as $entity)
    if ($entity->use_in_menu)
        $entities[] = [
            'id' => $entity->id,
            'name' => $entity->name_0
        ];
?>

    <style>
        .field-menu-types_helper, .field-menu-link {
            display: none;
        }
    </style>

    <div class="pages-form">
        <?php $form = ActiveForm::begin([
            'action' => $action
        ]); ?>

        <?= $form->field($model, 'menu_type_id')->hiddenInput(['value' => $menuType->id])->label(false) ?>
        <?= $form->field($model, 'type')->hiddenInput()->label(false) ?>
        <?= $form->field($model, 'type_helper')->hiddenInput()->label(false) ?>
        <?= $form->errorSummary($model) ?>

        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($model, 'types')->dropDownList([], [
                    'prompt' => Yii::t('cms', 'Choose')
                ]) ?>
                <div class="row">
                    <div class="col-sm-12">
                        <?= $form->field($model, 'types_helper')->dropDownList([]) ?>
                    </div>
                </div>
                <?= $form->field($model, 'link')->textInput(['placeholder' => 'http://']) ?>
            </div>
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-md-12">
                        <?php foreach (Yii::$app->params['cms']['languages'] as $key => $language) : ?>
                            <?= $form->field($model, 'title_' . $key)->textInput(['maxlength' => true, 'data-type' => 'titles']) ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('cms', 'Create') : Yii::t('cms', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

    <script>
        const [constEmpty,
                constAction,
                constLink,
                constOption,
                constItem,
                constCollection,
                constEntity,
                constEntityItem
            ] = JSON.parse('<?= JSON_encode(Menu::getTypes()) ?>'),

            typeValue = '<?= $model->type ?>',
            typesValue = '<?= $model->types ?>',
            helperValue = '<?= $model->types_helper ?>',

            collectionList = JSON.parse('<?= JSON_encode($collections) ?>'),
            entityList = JSON.parse('<?= JSON_encode($entities) ?>'),
            optionList = JSON.parse('<?= JSON_encode($options) ?>'),
            typeList = Object.entries(JSON.parse('<?= JSON_encode($model->typesList()) ?>')),
            actionList = Object.entries(JSON.parse('<?= JSON_encode($model->actionsList()) ?>')),
            ajaxUrl = '<?= Url::to(['menu/type']) ?>'
    </script>
<?php

$this->registerJsFile('/js/menu.js', ['depends' => [JqueryAsset::class]]);
