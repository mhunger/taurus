<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 02/04/17
 * Time: 18:38
 */

namespace taurus\framework\error;


class CannotSetValueInObjectException extends \Exception
{
    public function __construct($obj, $prpoerty, $value)
    {
        $msg = 'cannot set value in object: [' . print_r($obj, true) . '], prop: [' . $prpoerty . '], value: [' . $value . ']';
        parent::__construct($msg);
    }

}