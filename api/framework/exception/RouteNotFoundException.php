<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 23/10/16
 * Time: 14:17
 */

namespace api\framework\exception;


class RouteNotFoundException extends \Exception{
    public function __construct($path, $method) {
        parent::__construct("Could not load route for [$method], [$path]");
    }
}