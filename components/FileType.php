<?php


namespace abdualiym\cms\components;


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

	public static function fileMimeType($type)
	{
		if($type === null)
			return null;
		$type = (int)$type;
		return (self::MIME_TYPES[$type] === 'jpg'
			|| self::MIME_TYPES[$type] === 'jpeg'
			|| self::MIME_TYPES[$type] === 'png')
			? self::TYPE_IMAGE
			: self::TYPE_FILE;
	}

	public static function fileAccepts($type)
	{
		if($type === null)
			return null;

		$type = (int)$type;
		switch(self::MIME_TYPES[$type]) {
			case 'jpg':
				return '.jpg,.jpeg';
			case 'png':
				return '.png';
			case 'gif':
				return '.gif';
			case 'pdf':
				return '.pdf';
			case 'word':
				return '.doc,.docx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document';
			case 'excel':
				return '.xls,.xlsx';
			case 'mp4':
				return '.mp4';
			case 'mp3':
				return '.mp3';
		}

		throw new \Exception('mime type not Ok');
	}
}