<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 21/12/16
 * Time: 19:37
 */

namespace taurus\framework\container;

use taurus\framework\routing\RouteConfig;
use taurus\framework\routing\Request;
use taurus\framework\mock\MockServer;

interface ContainerConfig {
    const SERVICE_ROUTE_CONFIG = RouteConfig::class;
    const SERVICE_REQUEST = Request::class;
    const SERVICE_MOCK_SERVER = MockServer::class;

    public function getServiceConfigByName($name);
    public function merge(ContainerConfig $containerConfig);
    public function getServiceDefinitions();
}