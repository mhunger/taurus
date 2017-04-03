<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 02/04/17
 * Time: 18:36
 */

namespace taurus\framework\util;


use taurus\framework\error\CannotSetValueInObjectException;

class ObjectUtils
{
    /**
     * @param $obj
     * @param string $propertyName
     * @param $value
     * @throws CannotSetValueInObjectException
     */
    public function setObjectValue($obj, string $propertyName, $value)
    {
        if(is_object($obj)) {
            $reflectionClass = new \ReflectionClass($obj);

            if($reflectionClass->getMethod($this->getSetterMethodName($propertyName)) !== null) {
                call_user_func([
                    $obj,
                    $this->getSetterMethodName($propertyName),
                ], $value);
            } else {
                throw new CannotSetValueInObjectException($obj, $propertyName, $value);
            }
        }

    }

    /**
     * @param $property
     * @return string
     */
    private function getSetterMethodName($property)
    {
        return 'set' . ucfirst($property);
    }

    /**
     * @param $obj
     * @param string $property
     * @return mixed
     */
    public function getObjectValue($obj, string $property)
    {
        if(is_object($obj)) {
            $reflectionClass = new \ReflectionClass($obj);
            if($reflectionClass->getMethod($this->getGetterMethodName($property)) !== null) {
                return call_user_func([
                        $obj,
                        $this->getGetterMethodName($property)
                ]);
            }
        }
    }

    /**
     * @param string $property
     * @return string
     */
    private function getGetterMethodName(string $property): string
    {
        return 'get' . ucfirst($property);
    }
}