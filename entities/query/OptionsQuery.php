<?php


namespace afzalroq\cms\entities\query;

use creocoder\nestedsets\NestedSetsQueryBehavior;

class OptionsQuery extends \yii\db\ActiveQuery
{
    public function behaviors() {
        return [
            NestedSetsQueryBehavior::className(),
        ];
    }
}