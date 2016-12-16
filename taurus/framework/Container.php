<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 29/10/16
 * Time: 13:59
 */

namespace taurus\framework;


use fitnessmanager\config\ContainerConfig;
use fitnessmanager\workout\WorkoutController;
use taurus\framework\routing\Request;

class Container {

    /** @var Container */
    static private $instance = null;

    private function __construct() {}

    /**
     * @return Container
     */
    static public function getInstance() {
        if(self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param $name
     * @return Request
     */
    public function getService($name) {

        /**
         * @TODO build from config and check for null name
         */

        switch($name) {
            case ContainerConfig::SERVICE_REQUEST:
                return new Request();
                break;

            case ContainerConfig::SERVICE_WORKOUT_CONTROLLER:
                return new WorkoutController();
                break;
        }
    }
}