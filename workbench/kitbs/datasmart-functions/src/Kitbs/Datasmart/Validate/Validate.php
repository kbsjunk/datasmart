<?php namespace Kitbs\Datasmart\Validate;

use ReflectionClass;
use ReflectionException;
use Respect\Validation\Validator as Respect;
use Respect\Validation\Exceptions\AllOfException;
use Respect\Validation\Exceptions\ComponentException;
use Illuminate\Support\Facades\Config;

class Validate extends Respect {

    public static function start($ruleName, $arguments)
    {
        return static::__callStatic($ruleName, $arguments);
    }

    public static function buildRule($ruleSpec, $arguments=array())
    {
        if ($ruleSpec instanceof Validatable) {
            return $ruleSpec;
        }

        try {

            $validatorFqn = static::getNamespace($ruleSpec);
            $validatorClass = new ReflectionClass($validatorFqn);
            $validatorInstance = $validatorClass->newInstanceArgs(
                $arguments
                );

            return $validatorInstance;
        } catch (ReflectionException $e) {
            throw new ComponentException($e->getMessage());
        }
    }

    public static function tell($validated, $format = array('valid', 'invalid'))
    {
        return $validated ? $format[0] : $format[1];
    }

    public static function allowed($ruleName)
    {
        return (bool) static::getNamespace($ruleName, false);
    }

    public static function getNamespace($ruleName, $returnRuleName = true)
    {
        $namespaces = Config::get("datasmart::namespaces");
        $className = strtolower(get_class());

        $namespace = array_get($namespaces, "validate.$ruleName");

        if ($className != 'validate') {
            if ($otherClass = array_get($namespaces, "$className.$ruleName")) {
                $namespace = $otherClass;
            }
        }

        return $namespace . ( $returnRuleName ? ucfirst($ruleName) : false);
    }

}