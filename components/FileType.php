<?php


namespace afzalroq\cms\components;


class FileType
{
    const MIME_TYPES = [
        'jpg',
        'png',
        'svg',
        'gif',
        'pdf',
        'word',
        'excel',
        'mp4',
        'mp3',
    ];
    const TYPE_FILE = 0;
    const TYPE_IMAGE = 1;
    const TYPE_AUDIO = 8;
    const TYPE_VIDEO = 7;

    public static function fileExtensions($type)
    {
        if (!$type){
            return null;
        }
        
        $accepts = [];
        
        foreach ($type as $item) {
            switch (self::MIME_TYPES[$item]) {
                case 'jpg':
                    $accepts = array_merge($accepts, ['jpg', 'jpeg']);
                    break;
                case 'png':
                    $accepts = array_merge($accepts, ['png']);
                    break;
                case 'gif':
                    $accepts = array_merge($accepts, ['gif']);
                    break;
                case 'svg':
                    $accepts = array_merge($accepts, ['svg']);
                    break;
                case 'pdf':
                    $accepts = array_merge($accepts, ['pdf']);
                    break;
                case 'word':
                    $accepts = array_merge($accepts, ['doc', 'docx']);
                    break;
                case 'excel':
                    $accepts = array_merge($accepts, ['xls', 'xlsx']);
                    break;
                case 'mp4':
                    $accepts = array_merge($accepts, ['mp4']);
                    break;
                case 'mp3':
                    $accepts = array_merge($accepts, ['mp3']);
                    break;
            }
        }

        return $accepts;

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
        if (!$type)
            return null;

        $returnType = self::TYPE_IMAGE;

        foreach ($type as $item) {
            switch (self::MIME_TYPES[$item]){
                case "jpg" :
                case "png" :
                case "jpeg" :
                case "svg" :
                    $returnType = self::TYPE_IMAGE;
                    break;
                case "mp3":
                    $returnType = self::TYPE_AUDIO;
                    break;
                case "mp4":
                    $returnType = self::TYPE_VIDEO;
                    break;
                default:
                    $returnType = self::TYPE_FILE;
            }

            if ($returnType === self::TYPE_FILE)
                return $returnType;
        }
        return $returnType;
    }

    public static function fileAccepts($type)
    {
        if (!$type)
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
                case 'svg':
                    $accepts .= '.svg,';
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
