<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 19/12/16
 * Time: 20:06
 */

namespace taurus\framework\mock;


use taurus\framework\routing\Router;

class MockServer {

    /** @var Router */
    private $router;

    /** @var MockRequest */
    private $request;

    /**
     * @param Router $router
     * @param MockRequest $request
     */
    public function __construct(
        Router $router,
        MockRequest $request
    ) {
        $this->router = $router;
        $this->request = $request;
    }

    /**
     * @param $url
     * @param $method
     * @param $requestParams
     * @return string
     */
    public function get(
        $url,
        $method,
        $requestParams = []
    ) {

        $this->request->setMethod($method);
        $this->request->setUrl($url);
        $this->request->setRequestVariables($requestParams);

        $response = $this->router->route($this->request);

        return $response->getJson();
    }
}