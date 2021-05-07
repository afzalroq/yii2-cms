<?php


namespace afzalroq\cms\widgets;


use afzalroq\cms\components\FileType;
use afzalroq\cms\entities\CaE;
use afzalroq\cms\entities\Entities;
use afzalroq\cms\entities\Items;
use kartik\datecontrol\DateControl;
use kartik\file\FileInput;
use mihaildev\elfinder\ElFinder;
use sadovojav\ckeditor\CKEditor;
use Yii;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

class CmsForm
{
    /**
     * @var ActiveForm
     */
    public $form;
    /**
     * @var Items
     */
    public $model;
    /**
     * @var Entities|CaE
     */
    public $obj;

    public $entityTextAttrs;
    public $entityFileAttrs;

    public function __construct($form, $model, $obj = null)
    {
        $this->form = $form;
        $this->model = $model;
        $this->obj = $obj;

        if ($obj instanceof Entities)
            [$this->entityTextAttrs, $this->entityFileAttrs] = $this->obj->textAndFileAttrs();
    }

    public function oaIFields()
    {
        $caes = $this->obj->caes;
        usort($caes, function ($a, $b) {
            if ($a->sort == $b->sort)
                return 0;
            return ($a->sort < $b->sort) ? -1 : 1;
        });


        foreach ($caes as $cae) {
            if (empty($cae->collection->options))
                continue;

            switch ($cae->type) {
                case CaE::TYPE_CHECKBOX:
                    echo $this->oaiCheckboxList($cae);
                    break;
                case CaE::TYPE_SELECT:
                    echo $this->oaIDropdownList($cae);
                    break;
                case CaE::TYPE_RADIO:
                    echo $this->oaIRadioList($cae);
                    break;
                default:
                    echo '';
            }
        }
        return '';
    }

    public function fileFieldsTranslatable($key, &$hasTranslatableAttrs)
    {
        foreach ($this->entityFileAttrs as $entityAttr => $value)
            if ($this->obj->{$entityAttr} === Entities::FILE_TRANSLATABLE) {
                $attr = $entityAttr . '_' . $key;
                switch (FileType::fileMimeType($this->obj[$entityAttr . '_mimeType'])) {
                    case FileType::TYPE_FILE:
                        $hasTranslatableAttrs = 1;
                        echo $this->file($attr, $entityAttr, $this->obj[$entityAttr . '_label'], []);
                        break;
                    case FileType::TYPE_IMAGE:
                        $hasTranslatableAttrs = 1;
                        echo $this->image($attr, $entityAttr, $this->obj[$entityAttr . '_label'], []);
                        break;
                    default:
                        echo '';
                }
            }
        return '';
    }

    public function textFieldsTranslatable($langKey, &$hasTranslatableAttrs)
    {
        foreach ($this->entityTextAttrs as $entityAttr => $value) {
            $attr = $entityAttr . '_' . $langKey;
            switch ($this->obj{$entityAttr}) {
                case Entities::TEXT_TRANSLATABLE_INPUT_STRING:
                    $hasTranslatableAttrs = 1;
                    echo $this->input($attr, $entityAttr, []);
                    break;
                case Entities::TEXT_TRANSLATABLE_INPUT_STRING_REQUIRED:
                    $hasTranslatableAttrs = 1;
                    echo $this->input($attr, $entityAttr, ['required' => 'required']);
                    break;
                case Entities::TEXT_TRANSLATABLE_INPUT_INT:
                    $hasTranslatableAttrs = 1;
                    echo $this->input($attr, $entityAttr, ['type' => 'number']);
                    break;
                case Entities::TEXT_TRANSLATABLE_INPUT_INT_REQUIRED:
                    $hasTranslatableAttrs = 1;
                    echo $this->input($attr, $entityAttr, ['type' => 'number', 'required' => 'required']);
                    break;
                case Entities::TEXT_TRANSLATABLE_INPUT_URL:
                    $hasTranslatableAttrs = 1;
                    echo $this->input($attr, $entityAttr, ['type' => 'url']);
                    break;
                case Entities::TEXT_TRANSLATABLE_INPUT_URL_REQUIRED:
                    $hasTranslatableAttrs = 1;
                    echo $this->input($attr, $entityAttr, ['type' => 'url', 'required' => 'required']);
                    break;
                case Entities::TEXT_TRANSLATABLE_TEXTAREA:
                    $hasTranslatableAttrs = 1;
                    echo $this->textArea($attr, $entityAttr);
                    break;
                case Entities::TEXT_TRANSLATABLE_CKEDITOR:
                    $hasTranslatableAttrs = 1;
                    echo $this->ckeditor($attr, $this->obj[$entityAttr . '_label']);
                    break;
                default:
                    echo '';
                    break;
            }
        }
        return '';
    }

    public function fileFieldsCommon()
    {
        foreach ($this->entityFileAttrs as $entityAttr => $value)
            if ($this->obj->{$entityAttr} === Entities::FILE_COMMON) {
                $attr = $entityAttr . '_0';
                switch (FileType::fileMimeType($this->obj[$entityAttr . '_mimeType'])) {
                    case FileType::TYPE_FILE:
                        echo $this->file($attr, $entityAttr, $this->obj[$entityAttr . '_label'], []);
                        break;
                    case FileType::TYPE_IMAGE:
                        echo $this->image($attr, $entityAttr, $this->obj[$entityAttr . '_label'], []);
                        break;
                    default:
                        echo '';
                }
            }
        return '';
    }

    public function textFieldsCommon()
    {
        foreach ($this->entityTextAttrs as $entityAttr => $value) {
            $attr = $entityAttr . '_0';
            switch ($this->obj{$entityAttr}) {
                case Entities::TEXT_COMMON_INPUT_STRING:
                    echo $this->input($attr, $entityAttr, []);
                    break;
                case Entities::TEXT_COMMON_INPUT_STRING_REQUIRED:
                    echo $this->input($attr, $entityAttr, ['required' => 'required']);
                    break;
                case Entities::TEXT_COMMON_INPUT_INT:
                    echo $this->input($attr, $entityAttr, ['type' => 'number']);
                    break;
                case Entities::TEXT_COMMON_INPUT_INT_REQUIRED:
                    echo $this->input($attr, $entityAttr, ['type' => 'number', 'required' => 'required']);
                    break;
                case Entities::TEXT_COMMON_INPUT_URL:
                    echo $this->input($attr, $entityAttr, ['type' => 'url']);
                    break;
                case Entities::TEXT_COMMON_INPUT_URL_REQUIRED:
                    echo $this->input($attr, $entityAttr, ['type' => 'url', 'required' => 'required']);
                    break;
                case Entities::TEXT_COMMON_TEXTAREA:
                    echo $this->textArea($attr, $entityAttr);
                    break;
                case Entities::TEXT_COMMON_CKEDITOR:
                    echo $this->ckeditor($attr, $this->obj[$entityAttr . '_label']);
                    break;
                default:
                    echo '';
                    break;
            }
        }
        return '';
    }

    public function dateFieldCommon($attr)
    {
        switch ($this->obj['use_' . $attr]) {
            case Entities::USE_DATE_DATE:
                return $this->date($attr.'_0');
            case Entities::USE_DATE_DATETIME:
                return $this->date($attr.'_0', ['type' => DateControl::FORMAT_DATETIME]);
        }
    }

    public function dateFieldTranslatable($langKey, $attr)
    {
        switch ($this->obj['use_' . $attr]) {
            case Entities::USE_TRANSLATABLE_DATE_DATE:
                return $this->date($attr.'_'.$langKey);
            case Entities::USE_TRANSLATABLE_DATE_DATETIME:
                return $this->date($attr.'_'.$langKey, ['type' => DateControl::FORMAT_DATETIME]);
        }
    }

    #region Renders

    public function ckeditor($attr, $label = null, $options = [])
    {
        $options['editorOptions'] = ElFinder::ckeditorOptions('elfinder', [
            'extraPlugins' => 'image2,widget,oembed,video',
            'language' => Yii::$app->language,
            'height' => 300,
        ]);

        return Html::tag(
            'div',
            $this->form->field($this->model, $attr)->widget(CKEditor::class, $options)->label($label),
            ['class' => 'col-sm-12']
        );
    }

    public function textArea($attr, $entityAttr, $options = [])
    {
        return Html::tag(
            'div',
            $this->form->field($this->model, $attr)->textarea($options)->label($this->obj[$entityAttr . '_label']),
            ['class' => 'col-sm-6']
        );
    }

    public function input($attr, $entityAttr, $options)
    {
        $options['maxlength'] = true;

        return Html::tag(
            'div',
            $this->form->field($this->model, $attr)->textInput($options)->label($this->obj[$entityAttr . '_label']),
            ['class' => 'col-sm-6']
        );
    }

    public function date($attr, $options = ['type' => DateControl::FORMAT_DATE])
    {
        return Html::tag(
            'div',
            $this->form->field($this->model, $attr)->widget(DateControl::class, $options),
            ['class' => 'col-sm-4']
        );
    }

    public function image($attr, $entityAttr, $label, $options = [])
    {
        $options = array_merge([
            'options' => [
                'accept' => FileType::fileAccepts($this->obj[$entityAttr . '_mimeType'])
            ],
            'language' => Yii::$app->language,
            'pluginOptions' => [
                'showCaption' => false,
                'showRemove' => false,
                'showUpload' => false,
                'browseClass' => 'btn btn-primary btn-block',
                'browseLabel' => 'Рисунок',
                'layoutTemplates' => [
                    'main1' => '<div class="kv-upload-progress hide"></div>{cancel}{upload}{browse}{preview}',
                ],
                'initialPreviewAsData' => true,
                'initialPreview' => [
                    $this->model->getImageUrl(
                        $attr,
                        $this->obj[$entityAttr . '_dimensionW'],
                        $this->obj[$entityAttr . '_dimensionH']
                    )
                ],
                'maxFileSize' => $this->obj[$entityAttr . '_maxSize'] * 1024
            ],
        ], $options);

        return Html::tag(
            'div',
            $this->form->field($this->model, $attr)->widget(FileInput::class, $options)->label($label),
            ['class' => 'col-sm-4']
        );
    }

    public function file($attr, $entityAttr, $label, $options = [])
    {

        $options = array_merge([
            'options' => [
                'accept' => FileType::fileAccepts($this->obj[$entityAttr . '_mimeType'])
            ],
            'language' => Yii::$app->language,
            'pluginOptions' => [
                'showCaption' => false,
                'showRemove' => false,
                'showUpload' => false,
                'browseClass' => 'btn btn-primary btn-block',
                'layoutTemplates' => [
                    'main1' => '<div class="kv-upload-progress hide"></div>{cancel}{upload}{browse}{preview}',
                ],
                'initialPreviewFileType' => 'any',
                'initialPreviewConfig' => [
                    ['type' => 'pdf',],
                    ['type' => 'video']
                ],
                'initialPreviewAsData' => true,
                'initialPreview' => [
                    'http://localhost:20082/data/' . strtolower(StringHelper::basename($this->model::className())) . '/' . $this->model->id . '/' . $this->model[$attr]
                ],
                'maxFileSize' => $this->obj[$entityAttr . '_maxSize'] * 1024
            ],
        ], $options);

        return Html::tag(
            'div',
            $this->form->field($this->model, $attr)->widget(FileInput::class, $options)->label($label),
            ['class' => 'col-sm-4']
        );
    }

    public function oaICheckboxList(CaE $cae, $options = [])
    {
        $options['class'] = 'col-sm-' . $cae->size;

        return Html::tag(
            'div',
            $this->form->field($this->model, 'options[' . $cae->collection->slug . ']')->checkboxList($cae->getOptionList(), [
                    'value' => $this->model->getOptionValue($cae)
                ]
            )->label($cae->collection->name_0),
            $options
        );
    }

    public function oaIDropdownList(CaE $cae, $options = [])
    {
        $options['class'] = 'col-sm-' . $cae->size;

        return Html::tag(
            'div',
            $this->form->field($this->model, 'options[' . $cae->collection->slug . ']')->dropDownList($cae->getOptionList(), [
                    'value' => $this->model->getOptionValue($cae),
                    'prompt' => ''
                ]
            )->label($cae->collection->name_0),
            $options
        );
    }

    public function oaIRadioList(CaE $cae, $options = [])
    {
        $options['class'] = 'col-sm-' . $cae->size;

        return Html::tag(
            'div',
            $this->form->field($this->model, 'options[' . $cae->collection->slug . ']')->radioList($cae->getOptionList(), [
                    'value' => $this->model->getOptionValue($cae),
                ]
            )->label($cae->collection->name_0),
            $options
        );
    }

    #endregion
}