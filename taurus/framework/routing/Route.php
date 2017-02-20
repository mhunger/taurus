<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 20/02/17
 * Time: 21:24
 */

namespace taurus\framework\routing;


use taurus\framework\http\Controller;

interface Route
{

    public function getMethod(): string;

    public function getPath(): string;

    public function getController(): Controller;
}