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
    const APPLY_ON_INPUT = 1;

    const APPLY_ON_OUTPUT = 2;

    /**
     * @param $value
     * @param string|null $property
     * @return mixed
     */
    public function applyOnInput($value, string $property = null);


    /**
     * @param $value
     * @param string $property
     * @return mixed
     */
    public function applyOnOutput($value, string $property);
}