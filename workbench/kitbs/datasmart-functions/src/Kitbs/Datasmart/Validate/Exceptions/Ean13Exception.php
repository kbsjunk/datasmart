<?php namespace Kitbs\Datasmart\Validate\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class Ean13Exception extends ValidationException
{
    public static $defaultTemplates = array(
        self::MODE_DEFAULT => array(
            self::STANDARD => '{{name}} must be an EAN',
        ),
        self::MODE_NEGATIVE => array(
            self::STANDARD => '{{name}} must not be an EAN',
        )
    );
}