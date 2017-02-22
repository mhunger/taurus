<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 04/02/17
 * Time: 21:21
 */

namespace taurus\tests\fixtures;


/**
 * Class GlobalVariablesMock
 * @package taurus\tests\fixtures
 */
class GlobalVariablesMock
{
    /**
     * @var array
     */
    private $server;

    /**
     * @var array
     */
    private $request;

    /**
     * @var
     */
    private $session;

    function __construct()
    {
        $this->server = [
            'USER' => 'www-data',
            'HOME' => '/var/www',
            'FCGI_ROLE' => 'RESPONDER',
            'QUERY_STRING' => 'id=1',
            'REQUEST_METHOD' => 'GET',
            'CONTENT_TYPE' => '',
            'CONTENT_LENGTH' => '',
            'SCRIPT_FILENAME' => '/var/www/taurus-dev.com/web/index.php',
            'SCRIPT_NAME' => '/index.php',
            'REQUEST_URI' => '/api/items?id=1',
            'DOCUMENT_URI' => '/index.php',
            'DOCUMENT_ROOT' => '/var/www/taurus-dev.com/web',
            'SERVER_PROTOCOL' => 'HTTP/1.1',
            'GATEWAY_INTERFACE' => 'CGI/1.1',
            'SERVER_SOFTWARE' => 'nginx/1.4.6',
            'REMOTE_ADDR' => '192.168.44.1',
            'REMOTE_PORT' => '50627',
            'SERVER_ADDR' => '192.168.44.14',
            'SERVER_PORT' => '80',
            'SERVER_NAME' => '',
            'REDIRECT_STATUS' => '200',
            'HTTP_HOST' => 'taurus-dev.com',
            'HTTP_CONNECTION' => 'keep-alive',
            'HTTP_PRAGMA' => 'no-cache',
            'HTTP_CACHE_CONTROL' => 'no-cache',
            'HTTP_UPGRADE_INSECURE_REQUESTS' => '1',
            'HTTP_USER_AGENT' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.95 Safari/537.36',
            'HTTP_ACCEPT' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'HTTP_ACCEPT_ENCODING' => 'gzip, deflate, sdch',
            'HTTP_ACCEPT_LANGUAGE' => 'en-US,en;q=0.8,de;q=0.6',
            'PHP_SELF' => '/index.php',
            'REQUEST_TIME_FLOAT' => '1486238414.0867',
            'REQUEST_TIME' => '1486238414'
        ];

        $this->request = [
            'id' => 1
        ];
    }

    /**
     * @return array
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * @return array
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return mixed
     */
    public function getSession()
    {
        return $this->session;
    }

    public function setGlobalVariables()
    {
        $_SERVER = $this->server;
        $_REQUEST = $this->request;
    }
}