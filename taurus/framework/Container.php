<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 29/10/16
 * Time: 13:59
 */

namespace taurus\framework;

use taurus\framework\annotation\Reader;
use taurus\framework\error\ContainerCannotInstantiateService;

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
     * @return object
     * @throws ContainerCannotInstantiateService
     */
    public function getService($name) {
        if(!class_exists($name)) {
            throw new ContainerCannotInstantiateService('Cannot load service in container [' . $name . ']');
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

        if($constructor instanceof \ReflectionMethod && sizeof($constructor->getParameters()) > 0) {
            return $class->newInstanceArgs(
                $this->getArgs($constructor)
            );
        } else {
            return $class->newInstance();
        }
    }

    /**
     * @param \ReflectionMethod $constructor
     * @return array
     */
    private function getArgs(\ReflectionMethod $constructor) {
        $params = $constructor->getParameters();
        $args = [];

        foreach($params as $param) {
            $hintedClass = $param->getClass();

            if($hintedClass !== null) {
                $args[] = $this->injectDependenciesForReflectionClass($hintedClass->getName());
            }
        }

        return $args;
    }
}