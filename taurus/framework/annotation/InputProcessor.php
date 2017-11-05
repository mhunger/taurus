<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 05/11/17
 * Time: 18:26
 */

namespace taurus\framework\annotation;


interface InputProcessor
{

    /**
     * @param $value
     * @param string|null $property
     * @return mixed
     */
    public function apply($value, string $property = null);
}