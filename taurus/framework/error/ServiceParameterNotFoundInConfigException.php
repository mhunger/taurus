<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 21/12/16
 * Time: 18:53
 */

namespace taurus\framework\error;


class ServiceParameterNotFoundInConfigException extends \Exception
{
    /**
     * ServiceParameterNotFoundInConfigException constructor.
     * @param int $position
     * @param \ReflectionParameter $parameter
     * @internal param array $parameters
     * @internal param string $classname
     */
    public function __construct(int $position, \ReflectionParameter $parameter)
    {
        parent::__construct('No Parameter found in taurus configuration on position ['
            . $position . '] for class [' . $parameter->getName() . ']');
    }

}