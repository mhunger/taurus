<?php

/**
 * Created by PhpStorm.
 * User: michael_hunger
 * Date: 06/07/17
 * Time: 13:36
 */
class Taurus
{
    const routetpl = 'routeTpl';
    const containerTpl = 'containerTpl';
    const testContainerTpl = 'testContainerTpl';
    const appTpl = 'applicationTpl';
    const file = 'file';
    const tpl = 'tpl';
    const content = 'content';
    const basePath = 'base-path';
    const appname = 'app-name';
    const vars = 'vars';
    const route_config_class = 'route-config-class';
    const dbhost = 'dbhost';
    const dbuser = 'dbuser';
    const dbpw = 'dbpw';
    const db = 'db';
    const type = 'type';
    const app_container_class = 'app-container-class';
    const app_test_container_class = 'app-test-container-class';

    private $dbhost = 'localhost';
    private $dbuser = 'root';
    private $dbpw = 'root';


    const PROJECT_BASE_PATH = __DIR__ . '/..';

    static  $_noisy = true;

    /** @var array */
    private $args;

    /**
     * Taurus constructor.
     */
    public function __construct($args)
    {
        $this->args = $args;
        $this->appName = $args[1];
    }

    public function run()
    {
        $this->initApp($this->appName);

    }

    private function initApp(string $appName)
    {
        $this->createDirectories($appName);
        $this->createFiles($appName);
    }

    private function createFiles($appName)
    {
        $data = new ConfigFileTemplateData(
            'api',
            $appName,
                $this->getConfigClassName($appName, 'route'),
            $this->dbhost,
            $this->dbuser,
            $this->dbpw,
            $this->appName,
            $this->getConfigClassName($appName, 'container'),
            $this->getConfigClassName($appName, 'testContainer')
        );

        $this->createApplicationFile($appName, $data);

    }

    protected function createApplicationFile($appName, $data)
    {
        $appTpl = new ApplicationFileTemplate(
            'tpl/Application.php.tpl',
            $this->getAppPath($appName),
            $data
        );

        $appTpl->render();

        $appTpl->writeContent($this->getAppPath($appName), 'Application.php');

        $routeConfigTpl = new ApplicationFileTemplate(
            'tpl/RouteConfig.php.tpl',
            $this->getConfigPath($appName, 'route'),
            $data
        );

        $routeConfigTpl->render()->writeContent();

        $containerConfigTpl = new ApplicationFileTemplate(
            'tpl/ContainerConfig.php.tpl',
            $this->getConfigPath($appName, 'container'),
            $data
        );

        $containerConfigTpl->render()->writeContent();

        $testContainer = new ApplicationFileTemplate(
            'tpl/TestContainerConfig.php.tpl',
            $this->getConfigPath($appName, 'testContainer'),
            $data
        );

        $testContainer->render()->writeContent();

    }

    protected function createConfigFiles($appName, $data)
    {

    }

    private function createDirectories(string $appName)
    {
        $this->info( 'trying to create dir', self::PROJECT_BASE_PATH . '/' . $appName);

        if(!file_exists($this->getAppPath($appName))) {
            mkdir($this->getAppPath($appName));
        }

        $cnfDir = $this->getAppPath($appName) . '/config';
        $this->info('Trying to create config dir', $cnfDir);
        if(!file_exists($cnfDir)) {
            mkdir($cnfDir);
        }
    }

    public static function info($message, $argument)
    {
        if(self::$_noisy) {
            echo $message . ': [' . $argument . ']' . "\n";
        }
    }

    private function getAppPath(string $appName) {
        return self::PROJECT_BASE_PATH . '/' . $appName;
    }

    private function getConfigPath(string $appName, string $type) {
        return $this->getAppPath($appName) . '/config/' . $this->getConfigClassName($appName, $type) . '.php';
    }

    private function getConfigClassName(string $appName, string $type) {
        return ucfirst($appName) . ucfirst($type) . 'Config';
    }
}