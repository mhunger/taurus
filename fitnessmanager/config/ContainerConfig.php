<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 16/12/16
 * Time: 10:39
 */
namespace fitnessmanager\config;

use taurus\framework\container\AbstractContainerConfig;
use fitnessmanager\workout\GetWorkoutByIdController;

/**
 * FitnessManager specific container config. will be merged with taurus config
 * Class ContainerConfig
 * @package fitnessmanager\config
 */
class ContainerConfig extends AbstractContainerConfig {
    const SERVICE_WORKOUT_CONTROLLER = GetWorkoutByIdController::class;

    protected $serviceDefinitions = [];

    public function __construct() {}
}