<?php namespace Kitbs\Datasmart\Validate;

use ReflectionClass;
use ReflectionException;
use Respect\Validation\Validator as Respect;
use Respect\Validation\Exceptions\AllOfException;
use Respect\Validation\Exceptions\ComponentException;
use Illuminate\Support\Facades\Config;

class Validate extends Respect {

    public static function buildRule($ruleSpec, $arguments=array())
    {
        if ($ruleSpec instanceof Validatable) {
            return $ruleSpec;
        }

        try {

        	$namespace = Config::get('datasmart::namespaces.'.$ruleSpec);

            $validatorFqn = $namespace . ucfirst($ruleSpec);
            $validatorClass = new ReflectionClass($validatorFqn);
            $validatorInstance = $validatorClass->newInstanceArgs(
                $arguments
                );

            return $validatorInstance;
        } catch (ReflectionException $e) {
            throw new ComponentException($e->getMessage());
        }
    }

    public static function tell($validated) {
        return $validated ? 'valid' : 'invalid'; 
    }

}