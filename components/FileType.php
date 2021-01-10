<?php


namespace afzalroq\cms\components;


class FileType
{
    const MIME_TYPES = [
        'jpg',
        'png',
        'gif',
        'pdf',
        'word',
        'excel',
        'mp4',
        'mp3',
    ];
    const TYPE_FILE = 0;
    const TYPE_IMAGE = 1;

    public static function fileExtensions($type)
    {
        if ($type === null)
            return null;

        $accepts = '';
        foreach ($type as $item) {
            switch (self::MIME_TYPES[$item]) {
                case 'jpg':
                    $accepts .= 'jpg, jpeg,';
                    break;
                case 'png':
                    $accepts .= 'png,';
                    break;
                case 'gif':
                    $accepts .= 'gif,';
                    break;
                case 'pdf':
                    $accepts .= 'pdf,';
                    break;
                case 'word':
                    $accepts .= 'doc, .docx,';
                    break;
                case 'excel':
                    $accepts .= 'xls, xlsx,';
                    break;
                case 'mp4':
                    $accepts .= 'mp4,';
                    break;
                case 'mp3':
                    $accepts .= 'mp3,';
                    break;
            }
        }

        return substr($accepts, 0, -1);

        throw new \Exception('mime type not Ok');
    }


    public static function fileMimeTypes($array): string
    {
        $types = [];
        foreach ($array as $mimetype) {
            $types[] = self::MIME_TYPES[$mimetype];
        }
        return implode(", ", $types);
    }

    public static function fileMimeType($type)
    {
        if ($type === null)
            return null;

        $returnType = self::TYPE_IMAGE;

        foreach ($type as $item) {
            $returnType = (self::MIME_TYPES[$item] === 'jpg'
                || self::MIME_TYPES[$item] === 'jpeg'
                || self::MIME_TYPES[$item] === 'png')
                ? self::TYPE_IMAGE
                : self::TYPE_FILE;

            if ($returnType === self::TYPE_FILE)
                return $returnType;
        }
        return $returnType;
    }

    public static function fileAccepts($type)
    {
        if ($type === null)
            return null;

        $accepts = '';
        foreach ($type as $item) {
            switch (self::MIME_TYPES[$item]) {
                case 'jpg':
                    $accepts .= '.jpg,.jpeg,';
                    break;
                case 'png':
                    $accepts .= '.png,';
                    break;
                case 'gif':
                    $accepts .= '.gif,';
                    break;
                case 'pdf':
                    $accepts .= '.pdf,';
                    break;
                case 'word':
                    $accepts .= '.doc,.docx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,';
                    break;
                case 'excel':
                    $accepts .= '.xls,.xlsx,';
                    break;
                case 'mp4':
                    $accepts .= '.mp4,';
                    break;
                case 'mp3':
                    $accepts .= '.mp3,';
                    break;
            }
        }

        return substr($accepts, 0, -1);

        throw new \Exception('mime type not Ok');
    }


}