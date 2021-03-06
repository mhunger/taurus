<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 19/12/16
 * Time: 20:58
 */

namespace taurus\framework\mock;


use taurus\framework\config\TaurusConfig;
use taurus\framework\routing\Request;

class MockRequest extends Request {

    /**
     * MockRequest constructor.
     * @param TaurusConfig $taurusConfig
     */
    public function __construct(TaurusConfig $taurusConfig)
    {
        $this->taurusConfig = $taurusConfig;
    }


    /**
     * @param $url
     * @return MockRequest
     */
    public function setUrl($url): MockRequest
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @param $method
     * @return MockRequest
     */
    public function setMethod($method): MockRequest
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @param array $requestVariables
     * @return MockRequest
     */
    public function setRequestVariables(array $requestVariables): MockRequest
    {
        $this->requestVariables = $requestVariables;

        return $this;
    }

    /**
     * @param string $contentType
     */
    public function setContentType(string $contentType)
    {
        $this->contentType = $contentType;
    }

    /**
     * @param array $inputBody
     * @return MockRequest
     */
    public function setInputBody(array $inputBody): MockRequest
    {
        $this->inputBody = $inputBody;
        return $this;
    }


    /**
     * @param string $name
     * @param string $value
     * @return MockRequest
     */
    public function addHeader(string $name, string $value): MockRequest
    {
        $this->server[self::HTTP_HEADER_PREFIX . strtoupper(str_replace('-', '_', $name))] = $value;
        return $this;
    }

    /**
     * @param array $headers
     */
    public function setHeader(array $headers)
    {
        foreach($headers as $name => $value) {
            $this->addHeader($name, $value);
        }
    }
}
