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
use taurus\framework\annotation\Reader;
use taurus\framework\routing\Request;

class Container {

    /** @var Container */
    static private $instance = null;

    /** @var Reader */
    private $annotationReader;

    /**
     * @param Reader $annotationReader
     */
    private function __construct(Reader $annotationReader) {
        $this->annotationReader = $annotationReader;
    }

    /**
     * @return Container
     */
    static public function getInstance() {
        if(self::$instance === null) {
            self::$instance = new self(new Reader());
        }

        return self::$instance;
    }

    /**
     * @param $name
     * @return Request
     */
    public function getService($name) {


        switch($name) {
            case ContainerConfig::SERVICE_REQUEST:
                return new Request();
                break;

            case ContainerConfig::SERVICE_WORKOUT_CONTROLLER:
                return new WorkoutController();
                break;
        }

        return $this->injectDependenciesForReflectionClass($name);
    }

    /**
     * @param $class
     * @return object
     * @throws \Exception
     */
    private function injectDependenciesForReflectionClass($class) {
        $class = new \ReflectionClass($class);
        $constructor = $class->getConstructor();

        if($constructor instanceof \ReflectionMethod) {
            return $class->newInstanceArgs(
                $this->getArgs($constructor)
            );
        } else {
            return $class->newInstance();
        }
    }

    private function getArgs(\ReflectionMethod $constructor) {
        $params = $constructor->getParameters();

        foreach($params as $param) {
            $hintedClass = $param->getClass();

            $args[] = $this->injectDependenciesForReflectionClass($hintedClass->getName());
        }

        return $args;
    }
}