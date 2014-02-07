<?php namespace Kitbs\Datasmart\Validate\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class IsbnException extends ValidationException
{
    public static $defaultTemplates = array(
        self::MODE_DEFAULT => array(
            self::STANDARD => '{{name}} must be an ISBN',
        ),
        self::MODE_NEGATIVE => array(
            self::STANDARD => '{{name}} must not be an ISBN',
        )
    );
}