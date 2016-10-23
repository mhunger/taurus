<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 23/10/16
 * Time: 11:16
 */
namespace api;

use api\framework\routing\RouteConfig;
use api\framework\routing\Router;
use api\framework\Routing\Request;

class Application {

    private $router;

    public function run() {
        $this->registerAutoloader();

        $request = new Request();
        $this->router = new Router(new RouteConfig("api"));

        try {
            $this->router->route($request);
        } catch(\Exception $e) {
            echo "Could not route Request";
            exit;
        }
        echo "app loaded";
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