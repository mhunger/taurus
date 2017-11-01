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
use taurus\framework\container\ServiceRepository;
use taurus\framework\error\ContainerCannotInstantiateService;
use taurus\framework\error\ServiceParameterNotFoundInConfigException;

class Container {

    /** @var Container */
    static private $instance = null;

    /** @var ContainerConfig */
    private $containerConfig;

    /** @var ServiceRepository */
    private $serviceRepository;

    /**
     * Container constructor.
     */
    private function __construct()
    {
        $this->serviceRepository = new ServiceRepository();
    }

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
        if (class_exists($name)) {
            return $this->injectDependenciesForReflectionClass($name);
        }

        throw new ContainerCannotInstantiateService('Could not load service [' . $name . ']');
    }

    /**
     * @param ServiceConfig $serviceConfig
     * @param object $service
     * @return mixed
     */
    private function addToServiceRepoIfSingletonAndReturn($service, ServiceConfig $serviceConfig = null)
    {
        if (!is_null($serviceConfig) && $serviceConfig->isSingleton()) {
            return $this->serviceRepository
                ->getExistingOrAddAndReturnSingleton(
                    $serviceConfig->getClass(),
                    $service
                );
        }

        return $service;
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
            return $this->addToServiceRepoIfSingletonAndReturn(
                $reflectedClass->newInstanceArgs(
                    $this->getArgs($constructor, $serviceConfig)
                ),
                $serviceConfig
            );
        } else {
            return $this->addToServiceRepoIfSingletonAndReturn(
                $reflectedClass->newInstance(),
                $serviceConfig
            );
        }
    }

    /**
     * @param \ReflectionMethod $constructor
     * @param ServiceConfig $serviceConfig
     * @return array
     * @throws ServiceParameterNotFoundInConfigException
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
                    if(empty($className)) {
                        throw new ServiceParameterNotFoundInConfigException($pos, $param);
                    }
                } else {
                    //the parameter is a class we need the name to load it
                    $className = $hintedClass->getName();
                }

                $args[] = $this->injectDependenciesForReflectionClass($className);
            } else {
                //the parameter has no class, it is a literal; try loading argument from service definition
                if($serviceConfig !== null) {
                    $args[] = $serviceConfig->getParameterByPosition($pos, $param->isOptional());
                }
            }
        }

        return $args;
    }
}
