<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 29/10/16
 * Time: 13:59
 */

namespace taurus\framework;

use taurus\framework\container\ServiceConfig;
use taurus\framework\container\ContainerConfig;
use taurus\framework\config\TaurusContainerConfig;
use taurus\framework\container\ServiceRepository;
use taurus\framework\error\ContainerCannotInstantiateService;

class Container {

    /** @var Container */
    static private $instance = null;

    /** @var ContainerConfig */
    private $containerConfig;

    /** @var ServiceRepository */
    private $serviceRepository;

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
            return $this->injectDependenciesForServiceName($name);
        } else {
            return $this->injectDependenciesForReflectionClass($name);
        }
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
     * @param $serviceName
     * @return object
     * @throws ContainerCannotInstantiateService
     */
    private function injectDependenciesForServiceName($serviceName)
    {
        $serviceConfig = $this->containerConfig->getServiceConfigByName($serviceName);

        if ($serviceConfig === null) {
            throw new ContainerCannotInstantiateService('Could not load service [' . $serviceName . ']');
        }

        $reflectedClass = new \ReflectionClass($serviceConfig->getClass());
        $constructor = $reflectedClass->getConstructor();

        if ($constructor instanceof \ReflectionMethod && sizeof($constructor->getParameters()) > 0) {
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
                if($hintedClass->isInterface()) {
                    //The parameter is an interface; we need to load concrete class from serviceConfig
                    $className = $serviceConfig->getParameterByPosition($pos);
                } else {
                    //the parameter is a class we need the name to load it
                    $className = $hintedClass->getName();
                }

                $args[] = $this->injectDependenciesForReflectionClass($className);
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
