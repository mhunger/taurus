<?php
/**
 * Created by PhpStorm.
 * User: michael_hunger
 * Date: 20/07/17
 * Time: 08:59
 */

namespace bin\tpl;


use bin\Taurus;
use const null;

/**
 * Class TaurusInitiator
 * @package bin\tpl
 */
class TaurusInitiator
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

    /** @var string */
    private $appName;
    private $path = __DIR__ . '/../../';

    const TPL_PATH = __DIR__ . '/files';

    /**
     * TaurusInitiator constructor.
     * @param string $path
     */
    public function __construct($path = null)
    {
        if($path !== null) {
            $this->path = $path;
        }
    }

    /**
     * @param string $appName
     */
    public function initApp(string $appName, $path = null)
    {
        $this->createDirectories($appName);
        $this->createFiles($appName);
    }

    /**
     * @param $appName
     */
    private function createFiles(string $appName)
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

    /**
     * @param string $appName
     * @param ConfigFileTemplateData $data
     */
    protected function createApplicationFile(string $appName, ConfigFileTemplateData $data)
    {
        $appTpl = new TaurusProjectFileTemplate(
            self::TPL_PATH . '/Application.php.tpl',
            $this->getAppPath($appName),
            $data
        );

        $appTpl->render();

        $appTpl->writeContent($this->getAppPath($appName), 'Application.php');

        $config = [
            [
                'tpl' => 'RouteConfig',
                'type' => 'route'
            ],
            [
                'tpl' => 'ContainerConfig',
                'type' => 'container'
            ],
            [
                'tpl' => 'TestcontainerConfig',
                'type' => 'testContainer'
            ]
        ];

        foreach($config as $file) {
            $tpl = new TaurusProjectFileTemplate(
                self::TPL_PATH . '/' . $file['tpl'] . '.php.tpl',
                $this->getConfigPath($appName, $file['type']),
                $data
            );

            $tpl->render()
                ->writeContent();

            unset($tpl);
        }

        /** copy config file template */
        copy(
            self::TPL_PATH . DIRECTORY_SEPARATOR . 'appconfig.config.yaml',
            $this->getAppPath($appName) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . $appName . '.config.yaml'
        );

    }

    /**
     * @param string $appName
     */
    private function createDirectories(string $appName)
    {
        Taurus::info( 'trying to create dir', $this->path . '/' . $appName);

        if(!file_exists($this->getAppPath($appName))) {
            mkdir($this->getAppPath($appName));
        }

        $cnfDir = $this->getAppPath($appName) . '/config';
        Taurus::info('Trying to create config dir', $cnfDir);
        if(!file_exists($cnfDir)) {
            mkdir($cnfDir);
        }
    }

    /**
     * @param string $appName
     * @return string
     */
    private function getAppPath(string $appName) {
        return $this->path . '/' . $appName;
    }

    /**
     * @param string $appName
     * @param string $type
     * @return string
     */
    private function getConfigPath(string $appName, string $type) {
        return $this->getAppPath($appName) . '/config/' . $this->getConfigClassName($appName, $type) . '.php';
    }

    /**
     * @param string $appName
     * @param string $type
     * @return string
     */
    private function getConfigClassName(string $appName, string $type) {
        return ucfirst($appName) . ucfirst($type) . 'Config';
    }
}
