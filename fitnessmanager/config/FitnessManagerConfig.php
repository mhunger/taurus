<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 16/12/16
 * Time: 10:39
 */
namespace fitnessmanager\config;

use fitnessmanager\workout\GetAllWorkoutsController;
use taurus\framework\container\AbstractContainerConfig;
use fitnessmanager\workout\GetWorkoutByIdController;

/**
 * FitnessManager specific container config. will be merged with taurus config
 * Class ContainerConfig
 * @package fitnessmanager\config
 */
class FitnessManagerConfig extends AbstractContainerConfig {
    const SERVICE_GET_WORKOUT_BY_ID_CONTROLLER = GetWorkoutByIdController::class;
    const SERVICE_GET_WORKOUTS_CONTROLLER = GetAllWorkoutsController::class;



    protected $serviceDefinitions = [];

    /**
     * Method to define the ServicConfig objects for the config class
     *
     * @return mixed
     */
    protected function configure()
    {
        // TODO: Implement configure() method.
    }
}