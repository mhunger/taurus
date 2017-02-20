<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 20/02/17
 * Time: 21:27
 */

namespace taurus\framework\routing;


use taurus\framework\http\Controller;

class BasicRoute implements Route
{
    /**
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $path;

    /**
     * @var Controller
     */
    private $controller;

    /**
     * BasicRoute constructor.
     * @param string $method
     * @param string $path
     * @param Controller $controller
     */
    public function __construct(string $method, string $path, Controller $controller)
    {
        $this->method = $method;
        $this->path = $path;
        $this->controller = $controller;
    }

    /**
     * @return mixed
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return mixed
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return mixed
     */
    public function getController(): Controller
    {
        return $this->controller;
    }
}
