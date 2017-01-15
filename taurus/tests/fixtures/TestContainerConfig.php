<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 21/12/16
 * Time: 20:18
 */

namespace taurus\tests\fixtures;


use taurus\framework\container\AbstractContainerConfig;
use taurus\framework\container\ServiceConfig;
use taurus\framework\container\TaurusContainerConfig;
use taurus\tests\fixtures\LoadDependenciesForLiteralsTestClass;

class TestContainerConfig extends AbstractContainerConfig {

    const SERVICE_TEST_LITERALS = LoadDependenciesForLiteralsTestClass::class;
    const SERVICE_TEST_LITERALS_IN_DEPENDENCY = LoadDependenciesWithParamsInDependency::class;

    /**
     * Method to define the ServicConfig objects for the config class
     *
     * @return mixed
     */
    protected function configure()
    {
        $this->serviceDefinitions[self::SERVICE_TEST_LITERALS] =
        new ServiceConfig(
            self::SERVICE_TEST_LITERALS,
            null,
            [
                0 => 'literal1',
                2 => 100
            ]
        );

        $this->serviceDefinitions[TaurusContainerConfig::SERVICE_ROUTE_CONFIG] =
            new ServiceConfig(TaurusContainerConfig::SERVICE_ROUTE_CONFIG,
                null,
                ['api']
            );
    }


}