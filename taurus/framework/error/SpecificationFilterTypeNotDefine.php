<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 11/03/18
 * Time: 16:09
 */

namespace taurus\framework\error;


use Exception;

class SpecificationFilterTypeNotDefine extends \Exception
{
    public function __construct($message)
    {
        parent::__construct($message, 404);
    }
}