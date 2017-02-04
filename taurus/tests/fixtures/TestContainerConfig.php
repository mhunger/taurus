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
use taurus\framework\db\BaseRepository;
use taurus\framework\db\DatabaseManager;
use taurus\framework\db\entity\EntityMetaDataImpl;
use taurus\framework\db\mysql\MySqlConnection;
use taurus\framework\db\mysql\MySqlQueryStringBuilder;
use taurus\framework\Environment;
use taurus\tests\fixtures\LoadDependenciesForLiteralsTestClass;

class TestContainerConfig extends AbstractContainerConfig {

    const SERVICE_TEST_LITERALS = LoadDependenciesForLiteralsTestClass::class;
    const SERVICE_TEST_LITERALS_IN_DEPENDENCY = LoadDependenciesWithParamsInDependency::class;
    const SERVICE_ENVIRONMENT = Environment::class;
    const SERVICE_MYSQL_CONNECTION = MySqlConnection::class;
    const SERVICE_DB_MANAGER = DatabaseManager::class;
    const SERVICE_BASE_REPOSITORY = BaseRepository::class;
    const SERVICE_ENTITY_METADATA = EntityMetaDataImpl::class;

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

        $this->serviceDefinitions[self::SERVICE_ENVIRONMENT] =
            new ServiceConfig(self::SERVICE_ENVIRONMENT,
                'environment',
                [Environment::TEST]
            );

        $this->serviceDefinitions[self::SERVICE_MYSQL_CONNECTION] =
            new ServiceConfig(self::SERVICE_MYSQL_CONNECTION,
                'MysqlConnection',
                ['localhost', 'taurus', 'taurus', 'taurus', MySqlQueryStringBuilder::class]
            );

        $this->serviceDefinitions[self::SERVICE_DB_MANAGER] =
            new ServiceConfig(self::SERVICE_DB_MANAGER,
                'dbManager',
                [
                    MySqlConnection::class
                ]
            );

        $this->serviceDefinitions[self::SERVICE_BASE_REPOSITORY] =
            new ServiceConfig(self::SERVICE_BASE_REPOSITORY,
                'BaseRepository',
                [null, EntityMetaDataImpl::class, MySqlConnection::class]
            );
    }
}