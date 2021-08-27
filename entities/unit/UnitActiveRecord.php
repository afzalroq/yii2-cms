<?php

namespace afzalroq\cms\entities\unit;

use yii\db\ActiveRecord;
use afzalroq\cms\helpers\UnitType;

/**
 * @property int $id
 * @property int $created_at
 * @property int $updated_at
 */
abstract class UnitActiveRecord extends ActiveRecord
{
    public static function tableName()
    {
        return 'cms_unit_units';
    }

    abstract public function getData($key);

    abstract public function get();

    abstract public function getFormField($form, $key, $language);

    public function getKey()
    {
        if (in_array($this->type, [UnitType::TEXT_COMMON, UnitType::STRING_COMMON, UnitType::IMAGE_COMMON, UnitType::FILE_COMMON, UnitType::INPUT_COMMON])) {
            $key = 0;
        } else {
            $key = \Yii::$app->params['l'][\Yii::$app->language];
            if (!$this['data_' . $key]) {
                $key = 0;
            }
        }
        return $key;
    }
}
