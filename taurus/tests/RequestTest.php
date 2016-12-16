<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 23/10/16
 * Time: 11:50
 */

namespace taurus\tests;

use taurus\framework\routing\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase {
    private $testedRequest;

    private $requestUri;

    private $requestMethod;

    public function setUp() {
        $this->requestMethod = 'GET';
        $this->requestUri = '/my/items';

        $_SERVER['REQUEST_METHOD'] = $this->requestMethod;
        $_SERVER['REQUEST_URI'] = $this->requestUri;


    }
    public function testRequest() {
        $this->testedRequest = new Request();

        $this->assertEquals($this->requestMethod, $this->testedRequest->getMethod(), "Url is not matching");
        $this->assertEquals($this->requestUri, $this->testedRequest->getUrl(), "Url is not matching");

    }
}
