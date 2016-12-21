<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 21/12/16
 * Time: 19:37
 */

namespace taurus\framework\container;

interface ContainerConfig {
    const SERVICE_ROUTE_CONFIG = 'taurus\framework\routing\RouteConfig';
    const SERVICE_REQUEST = 'taurus\framework\routing\Request';
    const SERVICE_MOCK_SERVER = 'taurus\framework\mock\MockServer';

    public function getServiceConfigByName($name);
    public function merge(ContainerConfig $containerConfig);
    public function getServiceDefinitions();
}