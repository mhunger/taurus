<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 02/04/17
 * Time: 18:19
 */

namespace taurus\framework\exception;


class CannotMapRequestToSpecificationParameterException extends \Exception
{

    /**
     * CannotMapRequestToSpecificationParameterException constructor.
     * @param \ReflectionParameter $parameter
     * @param array $values
     */
    public function __construct(\ReflectionParameter $parameter, array $values)
    {
        $message = 'Cannot map param: [' . $parameter->getName() . '] into values: [' . implode(', ', $values). ']';
        parent::__construct($message);
    }
}