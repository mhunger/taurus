<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 23/10/16
 * Time: 11:16
 */
namespace taurus;

use taurus\framework\Container;
use taurus\framework\container\TaurusContainerConfig;
use taurus\framework\Environment;
use taurus\framework\routing\RouteConfig;
use taurus\framework\routing\Router;
use taurus\framework\routing\Request;

class Application {

    /** @var  Container */
    private $container;

    public function __construct() {

    }

    public function run() {
        $this->registerAutoloader();

        /** @var Request $request */
        $request = Container::getInstance()->getService(TaurusContainerConfig::SERVICE_REQUEST);
        $this->router = new Router(
            new RouteConfig("api"),
            new Environment(Environment::PROD)
        );

        try {
            $this->router->route($request);
        } catch(\Exception $e) {
            echo "Could not route Request";
            exit;
        }
    }

    /*
     * registers the vendor autoload file
     */
    private function registerAutoloader() {
        spl_autoload_register();
        $autoloadPath = __DIR__ . "/../vendor/autoload.php";
        if(is_file($autoloadPath)) {
            require_once $autoloadPath;
        }
    }
}
