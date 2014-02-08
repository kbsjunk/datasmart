<?php namespace Kitbs\Datasmart\Format;

use Kitbs\Datasmart\Validate\Validate;
use Illuminate\Support\Facades\Config;

class Format extends Validate {

    public function format($input) {
        $obj = array_shift($this->rules);

        if (method_exists($obj, 'format')) {
            return $obj->format($input);
        }
    }

}