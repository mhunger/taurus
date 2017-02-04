<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 23/10/16
 * Time: 11:31
 */

namespace taurus\framework\routing;


class Request {
    /**
     * @var
     */
    protected $url;

    /**
     * @var
     */
    protected $method;

    /**
     * @var
     */
    protected $requestVariables;

    /**
     *
     */
    public function __construct() {
        $this->server = $_SERVER;
        $this->request = $_REQUEST;

        $this->url = $this->parseUrl();
        $this->method = $this->parseMethod();
        $this->parseRequestParams();
    }

    /**
     *
     */
    private function parseRequestParams()
    {
        foreach ($_REQUEST as $name => $value) {
            $this->requestVariables[$name] = $value;
        }
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getParamByName($name)
    {
        if (isset($this->requestVariables[$name])) {
            return $this->requestVariables[$name];
        }
    }

    /**
     * @return mixed
     */
    public function getAllParams()
    {
        return $this->requestVariables;
    }

    /**
     * @return mixed
     */
    public function parseUrl() {
        return parse_url($this->server['REQUEST_URI'], PHP_URL_PATH);
    }

    /**
     * @return mixed
     */
    public function parseMethod() {
        return $this->server['REQUEST_METHOD'];
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
