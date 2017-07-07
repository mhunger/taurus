<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 19/06/17
 * Time: 20:16
 */

namespace carcada\config;

use ##app-name##\config\##route-config-class##;
use taurus\framework\config\TaurusContainerConfig;
use taurus\framework\container\AbstractContainerConfig;
use taurus\framework\container\ServiceConfig;
use taurus\framework\db\mysql\MySqlQueryStringBuilderImpl;

class ##app-container-class## extends AbstractContainerConfig
{
    const SERVICE_##app-name##_ROUTE_CONFIG = ##route-config-class##::class;

    protected function configure()
    {

        $this->serviceDefinitions[TaurusContainerConfig::SERVICE_MYSQL_CONNECTION] =
            new ServiceConfig(TaurusContainerConfig::SERVICE_MYSQL_CONNECTION,
                'MysqlConnection',
                ['##dbhost##', '##dbuser##', '##dbpw##', '##db##', MySqlQueryStringBuilderImpl::class],
                true
            );

        $this->serviceDefinitions[TaurusContainerConfig::SERVICE_ROUTER] =
            new ServiceConfig(TaurusContainerConfig::SERVICE_ROUTER,
                'router',
                [
                    ##route-config-class##::class,
                    null
                ]);

        $this->serviceDefinitions[self::SERVICE_##app-name##_ROUTE_CONFIG] =
            new ServiceConfig(self::SERVICE_##app-name##_ROUTE_CONFIG,
                null,
                [##route-config-class##::API_BASE_PATH],
                true
            );
    }
}