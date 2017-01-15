<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 29/10/16
 * Time: 13:59
 */

namespace taurus\framework;

use taurus\framework\annotation\Reader;
use taurus\framework\container\ServiceConfig;
use taurus\framework\container\TaurusContainerConfig;
use taurus\framework\container\ContainerConfig;
use taurus\framework\error\ContainerCannotInstantiateService;

class Container {

    /** @var Container */
    static private $instance = null;

    /** @var Reader */
    private $annotationReader;

    /** @var ContainerConfig */
    private $containerConfig;

    /**
     * @param Reader $annotationReader
     * @param ContainerConfig $containerConfig
     */
    private function __construct(
        Reader $annotationReader,
        ContainerConfig $containerConfig
    ) {
        $this->annotationReader = $annotationReader;
        $this->containerConfig = $containerConfig;
    }

    /**
     * @return Container
     */
    static public function getInstance() {
        if(self::$instance === null) {
            self::$instance = new self(
                new Reader(),
                new TaurusContainerConfig());
        }

        return self::$instance;
    }

    /**
     * @param ContainerConfig $taurusContainerConfig
     * @return $this
     */
    public function setContainerConfig(ContainerConfig $taurusContainerConfig) {
        $this->containerConfig = $taurusContainerConfig;
        return $this;
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
     * @param $fullClassName
     * @return object
     */
    private function injectDependenciesForReflectionClass($fullClassName) {
        $reflectedClass = new \ReflectionClass($fullClassName);
        $serviceConfig = $this->containerConfig->getServiceConfigByName($fullClassName);

        $constructor = $reflectedClass->getConstructor();

        if($constructor instanceof \ReflectionMethod && sizeof($constructor->getParameters()) > 0) {
            return $reflectedClass->newInstanceArgs(
                $this->getArgs($constructor, $serviceConfig)
            );
        } else {
            return $reflectedClass->newInstance();
        }
    }

    /**
     * @param \ReflectionMethod $constructor
     * @param ServiceConfig $serviceConfig
     * @return array
     */
    private function getArgs(\ReflectionMethod $constructor, ServiceConfig $serviceConfig = null) {
        $params = $constructor->getParameters();
        $args = [];

        foreach($params as $pos => $param) {
            $hintedClass = $param->getClass();

            //the parameter of constructor has a class and can be injected
            if($hintedClass !== null) {
                $args[] = $this->injectDependenciesForReflectionClass($hintedClass->getName());
            } else {
                //the parameter has no class, it is a literal; try loading argument from service definition
                if($serviceConfig !== null) {
                    $args[] = $serviceConfig->getParameterByPosition($pos);
                }
            }
        }

        return $args;
    }
}
