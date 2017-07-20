<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 19/06/17
 * Time: 20:16
 */

namespace testApp\config;

use testApp\config\TestAppRouteConfig;
use taurus\framework\config\TaurusContainerConfig;
use taurus\framework\container\AbstractContainerConfig;
use taurus\framework\container\ServiceConfig;
use taurus\framework\db\mysql\MySqlQueryStringBuilderImpl;

class TestAppContainerConfig extends AbstractContainerConfig
{
    const SERVICE_testApp_ROUTE_CONFIG = TestAppRouteConfig::class;

    protected function configure()
    {

        $this->serviceDefinitions[TaurusContainerConfig::SERVICE_MYSQL_CONNECTION] =
            new ServiceConfig(TaurusContainerConfig::SERVICE_MYSQL_CONNECTION,
                'MysqlConnection',
                ['localhost', 'root', 'root', '', MySqlQueryStringBuilderImpl::class],
                true
            );

        $this->serviceDefinitions[TaurusContainerConfig::SERVICE_ROUTER] =
            new ServiceConfig(TaurusContainerConfig::SERVICE_ROUTER,
                'router',
                [
                    TestAppRouteConfig::class,
                    null
                ]);

        $this->serviceDefinitions[self::SERVICE_testApp_ROUTE_CONFIG] =
            new ServiceConfig(self::SERVICE_testApp_ROUTE_CONFIG,
                null,
                [TestAppRouteConfig::API_BASE_PATH],
                true
            );
    }
}
