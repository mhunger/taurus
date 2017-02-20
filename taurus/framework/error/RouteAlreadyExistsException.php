<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 20/02/17
 * Time: 21:04
 */

namespace taurus\framework\error;


class RouteAlreadyExistsException extends \Exception
{
    public function __construct($method, $name)
    {
        $message = 'Could not add route: [' . $method . '][' . $name . ']. Route already exists.';
        parent::__construct($message);
    }
}