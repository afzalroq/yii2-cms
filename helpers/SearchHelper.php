<?php

namespace afzalroq\cms\helpers;


use yii\web\BadRequestHttpException;

class SearchHelper
{
    public static function validate($text): string
    {
        if (!is_string($text)) {
            throw new BadRequestHttpException('Invalid params entered.');
        }
        return strip_tags(mb_substr(trim($text), 0, 20));
    }

}
