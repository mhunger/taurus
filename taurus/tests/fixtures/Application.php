<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 23/10/16
 * Time: 11:16
 */
namespace testApp;

use taurus\framework\config\TaurusConfig;
use testApp\config\TestAppContainerConfig;
use testApp\config\TestAppTestContainerConfig;
use taurus\framework\Container;
use taurus\framework\config\TaurusContainerConfig;
use taurus\framework\Environment;
use taurus\framework\routing\Router;
use taurus\framework\routing\Request;

class Application {

    /** @var Router */
    private $router;

    /** @var string */
    private $env;

    public function boot(): Application
    {
        $this->registerAutoloader();
        $this->env = $this->setEnv();
        $this->bootConfig();
        return $this;
    }

    private function setEnv()
    {
        return getenv(Environment::ENV_VARIABLE_NAME);
    }

    private function bootConfig()
    {
        $config = new TaurusContainerConfig();
        $config->merge(new TestAppContainerConfig());
        if($this->env == Environment::TEST) {
            $config->merge(
                new TestAppTestContainerConfig()
            );
        }

        Container::getInstance()->setContainerConfig($config);
        /** @var TaurusConfig $taurusConfig */
        $taurusConfig = Container::getInstance()->getService(TaurusContainerConfig::SERVICE_TAURUS_CONFIG);
        $taurusConfig->loadUserConfigFromYaml(file_get_contents(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config'. DIRECTORY_SEPARATOR . 'testApp.conf.yaml'));
    }

    public function run()
    {
        /** @var Request $request */
        $request = Container::getInstance()->getService(TaurusContainerConfig::SERVICE_REQUEST);
        $this->router = Container::getInstance()->getService(TaurusContainerConfig::SERVICE_ROUTER);

        try {
            $this->router->route($request);
        } catch(\Exception $e) {
            error_log($e);
            echo 'Could not route request';
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
