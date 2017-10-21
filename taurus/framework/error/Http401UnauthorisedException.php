<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 15/10/17
 * Time: 23:10
 */

namespace taurus\framework\error;


use Exception;

class Http401UnauthorisedException extends \Exception
{
    public function __construct($message = "")
    {
        parent::__construct($message);
    }

}