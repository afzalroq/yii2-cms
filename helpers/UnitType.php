<?php

namespace afzalroq\cms\helpers;

class UnitType
{

    const STRINGS = 1;
    const STRING_COMMON = 2;
    const IMAGES = 11;
    const IMAGE_COMMON = 12;
    const FILES = 15;
    const FILE_COMMON = 16;
    const TEXTS = 21;
    const TEXT_COMMON = 22;
    const INPUTS = 25;
    const INPUT_COMMON = 26;


    public static function config($type): array
    {
        switch ($type) {
            case self::IMAGES:
                return self::imageConfig();
            case self::IMAGE_COMMON:
                return self::imageConfig(true);
            case self::FILES:
                return self::fileConfig();
            case self::FILE_COMMON:
                return self::fileConfig(true);
            default:
                return [];
        };
    }

    public static function name($key)
    {
        $list = self::list();
        return $list[$key];
    }

    public static function list()
    {
        return [
            self::INPUTS => \Yii::t('unit', 'Translateable inputs'),
            self::INPUT_COMMON => \Yii::t('unit', 'Common input'),
            self::STRINGS => \Yii::t('unit', 'Translateable strings'),
            self::STRING_COMMON => \Yii::t('unit', 'Common string'),
            self::TEXTS => \Yii::t('unit', 'Translateable texts'),
            self::TEXT_COMMON => \Yii::t('unit', 'Common text'),
            self::IMAGES => \Yii::t('unit', 'Translateable images'),
            self::IMAGE_COMMON => \Yii::t('unit', 'Common image'),
            self::FILES => \Yii::t('unit', 'Translateable files'),
            self::FILE_COMMON => \Yii::t('unit', 'Common file')
        ];
    }
}
