<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 16/12/16
 * Time: 10:39
 */
namespace fitnessmanager\config;

class ContainerConfig {
    const SERVICE_REQUEST = 'taurus\framework\routing\Request';
    const SERVICE_WORKOUT_CONTROLLER = 'fitnessmanager\workout\GetWorkoutByIdController';
    const SERVICE_MOCK_SERVER = 'taurus\framework\mock\MockServer';
}