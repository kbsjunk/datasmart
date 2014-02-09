<?php namespace Kitbs\Datasmart\Facades;

use Illuminate\Support\Facades\Facade;

class Datasmart extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'datasmart'; }

}