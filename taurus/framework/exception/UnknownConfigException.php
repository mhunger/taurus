<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 12/11/17
 * Time: 15:11
 */

namespace taurus\framework\exception;


use Exception;

class UnknownConfigException extends \Exception
{
    public function __construct(string $config, $value)
    {
        parent::__construct('Wrong Configuration was attempted to set: [' . $config . '][' . $value . ']');
    }
}