<?php

namespace afzalroq\cms\entities\unit\Unit;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $created_at
 * @property int $updated_at
 */
abstract class UnitActiveRecord extends ActiveRecord
{
    public static function tableName()
    {
        return 'afzalroq_unit_units';
    }

    abstract public function getData($key);

    abstract public function get();

    abstract public function getFormField($form, $key, $language);
}
