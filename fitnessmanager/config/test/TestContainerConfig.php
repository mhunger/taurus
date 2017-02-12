<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 21/12/16
 * Time: 20:18
 */

namespace fitnessmanager\config\test;


use fitnessmanager\workout\GetAllWorkoutsController;
use taurus\framework\container\AbstractContainerConfig;
use taurus\framework\container\ServiceConfig;
use taurus\framework\config\TaurusContainerConfig;
use taurus\framework\db\entity\BaseRepository;
use taurus\framework\db\entity\DatabaseManager;
use taurus\framework\db\entity\EntityAccessLayer;
use taurus\framework\db\entity\EntityMetaDataImpl;
use taurus\framework\db\entity\EntityMetaDataStore;
use taurus\framework\db\EntityBuilder;
use taurus\framework\db\mysql\MySqlConnection;
use taurus\framework\db\mysql\MysqlInsertQueryStringBuilder;
use taurus\framework\db\mysql\MySqlQueryStringBuilderImpl;
use taurus\framework\db\mysql\MysqlSelectQueryStringBuilder;
use taurus\framework\Environment;
use taurus\framework\routing\RouteConfig;
use taurus\tests\fixtures\LoadDependenciesForLiteralsTestClass;
use taurus\tests\fixtures\LoadDependenciesWithParamsInDependency;
use taurus\tests\fixtures\TestSingleton;

class TestContainerConfig extends AbstractContainerConfig {

    const SERVICE_TEST_LITERALS = LoadDependenciesForLiteralsTestClass::class;
    const SERVICE_TEST_LITERALS_IN_DEPENDENCY = LoadDependenciesWithParamsInDependency::class;
    const SERVICE_ENVIRONMENT = Environment::class;
    const SERVICE_MYSQL_CONNECTION = MySqlConnection::class;
    const SERVICE_GET_WORKOUTS_CONTROLLER = GetAllWorkoutsController::class;
    const SERVICE_TEST_SINGLETON = TestSingleton::class;

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
                [RouteConfig::API_BASE_PATH],
                true
            );

        $this->serviceDefinitions[self::SERVICE_ENVIRONMENT] =
            new ServiceConfig(self::SERVICE_ENVIRONMENT,
                'environment',
                [Environment::TEST],
                true
            );

        $this->serviceDefinitions[self::SERVICE_MYSQL_CONNECTION] =
            new ServiceConfig(self::SERVICE_MYSQL_CONNECTION,
                'MysqlConnection',
                ['localhost', 'taurus', 'taurus', 'taurus_test', MySqlQueryStringBuilderImpl::class],
                true
            );

        $this->serviceDefinitions[self::SERVICE_TEST_SINGLETON] =
            new ServiceConfig(self::SERVICE_TEST_SINGLETON,
                'singletonTestClass',
                [1],
                true
            );
    }
}
