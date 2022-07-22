<?php

namespace afzalroq\cms\components;

class CMSWidget
{
    public static function safe(string $widgetClass, array $config = []): string
    {
        try {
            return $widgetClass::widget($config);
        } catch (\Throwable $e) {
            return $widgetClass . ": " . $e->getMessage();
        }
    }
}
