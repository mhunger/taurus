<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 23/10/16
 * Time: 11:31
 */

namespace taurus\framework\routing;


class Request {
    protected $url;

    protected $method;

    public function __construct() {
        $this->url = $this->parseUrl();
        $this->method = $this->parseMethod();
    }

    public function parseUrl() {
        return $_SERVER['REQUEST_URI'];
    }

    public function parseMethod() {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }
}