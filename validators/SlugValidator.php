<?php

namespace afzalroq\cms\validators;

use yii\validators\RegularExpressionValidator;

class SlugValidator extends RegularExpressionValidator
{
    public $pattern = '#^[a-z0-9-]*$#s';
    public $message = 'Only [a-z0-9-] symbols are allowed.';
}
