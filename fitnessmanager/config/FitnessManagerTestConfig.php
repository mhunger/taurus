<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 16/12/16
 * Time: 10:39
 */
namespace fitnessmanager\config;

use fitnessmanager\workout\GetAllWorkoutsController;
use taurus\framework\config\TaurusContainerConfig;
use taurus\framework\container\AbstractContainerConfig;
use fitnessmanager\workout\GetWorkoutByIdController;
use taurus\framework\container\ServiceConfig;
use taurus\framework\db\mysql\MySqlQueryStringBuilderImpl;
use taurus\framework\Environment;

/**
 * FitnessManager specific container config. will be merged with taurus config
 * Class ContainerConfig
 * @package fitnessmanager\config
 */
class FitnessManagerTestConfig extends AbstractContainerConfig {
    const SERVICE_GET_WORKOUT_BY_ID_CONTROLLER = GetWorkoutByIdController::class;
    const SERVICE_GET_WORKOUTS_CONTROLLER = GetAllWorkoutsController::class;
    const SERVICE_FITNESSMANAGER_ROUTE_CONFIG = FitnessManagerRouteconfig::class;

    protected $serviceDefinitions = [];

    /**
     * Method to define the ServicConfig objects for the config class
     *
     * @return mixed
     */
    protected function configure()
    {
        $this->serviceDefinitions[TaurusContainerConfig::SERVICE_MYSQL_CONNECTION] =
            new ServiceConfig(TaurusContainerConfig::SERVICE_MYSQL_CONNECTION,
                'MysqlConnection',
                ['localhost', 'fitness', 'fitness', 'fitnessmanager_test', MySqlQueryStringBuilderImpl::class],
                true
            );

        $this->serviceDefinitions[TaurusContainerConfig::SERVICE_ROUTER] =
            new ServiceConfig(TaurusContainerConfig::SERVICE_ROUTER,
                'router',
                [
                    FitnessManagerRouteconfig::class,
                    null
                ]);

        $this->serviceDefinitions[self::SERVICE_FITNESSMANAGER_ROUTE_CONFIG] =
            new ServiceConfig(self::SERVICE_FITNESSMANAGER_ROUTE_CONFIG,
                null,
                [FitnessManagerRouteconfig::API_BASE_PATH],
                true
            );
        $this->serviceDefinitions[TaurusContainerConfig::SERVICE_ENVIRONMENT] =
            new ServiceConfig(TaurusContainerConfig::SERVICE_ENVIRONMENT,
                'environment',
                [Environment::TEST],
                true
            );
    }
}
