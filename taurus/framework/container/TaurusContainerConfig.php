<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 21/12/16
 * Time: 19:58
 */

namespace taurus\framework\container;

use taurus\framework\mock\MockServer;
use taurus\framework\routing\Request;
use taurus\framework\routing\RouteConfig;

/**
 * Standard taurus container config contains all the services used inside taurus
 *
 * Class TaurusContainerConfig
 * @package taurus\framework\container
 */
class TaurusContainerConfig extends AbstractContainerConfig {

    const SERVICE_ROUTE_CONFIG = RouteConfig::class;
    const SERVICE_REQUEST = Request::class;
    const SERVICE_MOCK_SERVER = MockServer::class;

    public function __construct() {
        $this->configure();
    }

    /**
     * Method to define the ServicConfig objects for the config class
     *
     * @return mixed
     */
    protected function configure()
    {
        $this->serviceDefinitions[self::SERVICE_ROUTE_CONFIG] =
            new ServiceConfig(self::SERVICE_ROUTE_CONFIG,
                null,
                ['api']
            );
    }
}