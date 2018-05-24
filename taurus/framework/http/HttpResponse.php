<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 15/12/16
 * Time: 10:49
 */

namespace taurus\framework\http;

abstract class HttpResponse {

    /** @var array  */
    private $headers;

    /** @var string  */
    protected $body;

    /** @var string */
    private $contentType;

    /** @var int */
    private $responseCode;

    /**
     * @param $responseCode
     * @param $body
     * @param string $contentType
     * @param $additionalHeaders
     */
    public function __construct($responseCode, $body, $contentType = 'application/json', $additionalHeaders = array()) {
        $this->responseCode = $responseCode;
        $this->body = $body;
        $this->contentType = $contentType;
        $this->headers = $additionalHeaders;
    }

    public function send() {
        $this->sendHeader();
        $this->body();
        $this->sendResponseCode();
    }

    private function sendHeader() {
        header("Content-Type: " . $this->contentType . "\n", true, $this->responseCode);

        foreach($this->headers as $name => $v) {
            header($name . ': ' . $v . "\n");
        }
    }

    private function sendResponseCode()
    {
        http_response_code($this->responseCode);
    }

    abstract protected function body();
}
