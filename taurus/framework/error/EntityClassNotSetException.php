<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 20/02/17
 * Time: 20:38
 */

namespace taurus\framework\error;


use Exception;

class EntityClassNotSetException extends \Exception
{
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {

        parent::__construct($message, $code, $previous);
    }

}