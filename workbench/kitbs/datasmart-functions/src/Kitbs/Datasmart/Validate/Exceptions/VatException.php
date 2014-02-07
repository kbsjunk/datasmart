<?php namespace Kitbs\Datasmart\Validate\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class VatException extends ValidationException
{
    public static $defaultTemplates = array(
        self::MODE_DEFAULT => array(
            self::STANDARD => '{{name}} must be a VAT Identification Number',
        ),
        self::MODE_NEGATIVE => array(
            self::STANDARD => '{{name}} must not be a VAT Identification Number',
        )
    );
}