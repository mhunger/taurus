<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 31/05/18
 * Time: 18:26
 */

namespace taurus\framework\error;


class InvalidInputException extends \Exception
{
    public function __construct($value){
        parent::__construct('[' . $value . '] is not a valid geo point. Please pass a value matching format x, y');
    }
}