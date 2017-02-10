<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 23/10/16
 * Time: 11:16
 */
namespace taurus;

use fitnessmanager\config\FitnessManagerConfig;
use taurus\framework\Container;
use taurus\framework\config\TaurusContainerConfig;
use taurus\framework\db\entity\DatabaseManager;
use taurus\framework\Environment;
use taurus\framework\routing\RouteConfig;
use taurus\framework\routing\Router;
use taurus\framework\routing\Request;

class Application {

    /** @var DatabaseManager */
    private $dbManager;

    /** @var Router */
    private $router;

    /** @var string */
    private $env;

    public function boot(): Application
    {
        $this->registerAutoloader();
        $this->dbManager = Container::getInstance()->getService(TaurusContainerConfig::SERVICE_DB_MANAGER);
        $this->setEnv();
        $this->bootConfig();

        return $this;
    }

    private function setEnv()
    {
        if (isset($_ENV[Environment::ENV_VARIABLE_NAME])) {
            $this->env = $_ENV[Environment::ENV_VARIABLE_NAME];
        }

        if (isset($_SERVER[Environment::ENV_VARIABLE_NAME])) {
            $this->env = $_ENV[Environment::ENV_VARIABLE_NAME];
        }
    }

    private function bootConfig()
    {
        $config = new TaurusContainerConfig();
        $config->merge(new FitnessManagerConfig());
        if($this->env == Environment::TEST) {
            $config->merge(
                new TaurusContainerConfig()
            );
        }
    }

    public function run()
    {
        /** @var Request $request */
        $request = Container::getInstance()->getService(TaurusContainerConfig::SERVICE_REQUEST);
        $this->router = Container::getInstance()->getService(TaurusContainerConfig::SERVICE_ROUTER);

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
