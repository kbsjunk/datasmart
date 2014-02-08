<?php namespace Kitbs\Datasmart\Format;

use Kitbs\Datasmart\Validate\Validate;
use Illuminate\Support\Facades\Config;

class Format extends Validate {

    public function format($input) {
        return $input;
    }

}