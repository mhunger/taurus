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
     *
     */
    const HTTP_PUT = 'PUT';

    const HTTP_GET = 'GET';

    const HTTP_POST = 'POST';

    const HTTP_DELETe = 'DELETE';

    /**
     *
     */
    const HTTP_CONTENT_TYPE_APPLICATION_JSON = 'application/json';

    /**
     * Header prefix for http header
     */
    const HTTP_HEADER_PREFIX = 'HTTP_';

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

    /** @var string */
    protected $contentType;

    /** @var \stdClass */
    protected $inputBody;

    /** @var array */
    protected $server;
    /**
     *
     */
    public function __construct() {
        $this->server = $_SERVER;
        $this->request = $_REQUEST;

        $this->url = $this->parseUrl();
        $this->method = $this->parseMethod();
        $this->contentType = $this->getContentType();
        $this->parseRequestParams();
        $this->parseRawPostData();
    }

    /**
     * @return mixed
     */
    private function getContentType()
    {
        return $this->server['CONTENT_TYPE'];
    }

    /**
     *
     */
    private function parseRawPostData()
    {
        $content = file_get_contents('php://input');
        if($this->contentType == self::HTTP_CONTENT_TYPE_APPLICATION_JSON) {
            $this->inputBody = json_decode($content, true);
        }
    }

    /**
     * @return \stdClass
     */
    public function getInputBody(){
        return $this->inputBody;
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
    public function getRequestParamByName($name)
    {
        if (isset($this->requestVariables[$name])) {
            return $this->requestVariables[$name];
        }
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getBodyParamByName($name) {
        if(isset($this->inputBody[$name])) {
            return $this->inputBody[$name];
        }
    }

    /**
     * @return mixed
     */
    public function getAllParams()
    {
        return $this->requestVariables;
    }

    public function getHeader(string $headerName)
    {
        return $this->server[self::HTTP_HEADER_PREFIX . strtoupper(str_replace('-', '_', $headerName))];
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
