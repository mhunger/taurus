<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 19/12/16
 * Time: 20:58
 */

namespace taurus\framework\mock;


use taurus\framework\routing\Request;

class MockRequest extends Request {

    public function __construct() {
        //do nothing here
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @param mixed $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * @param mixed $requestVariables
     */
    public function setRequestVariables($requestVariables)
    {
        $this->requestVariables = $requestVariables;
    }
}