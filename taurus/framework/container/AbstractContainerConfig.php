<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 21/12/16
 * Time: 19:48
 */

namespace taurus\framework\container;

/**
 * Use this class to implement a new config for the system.
 *
 * Class AbstractContainerConfig
 * @package taurus\framework\container
 */
abstract class AbstractContainerConfig implements ContainerConfig{

    /** @var array */
    protected $serviceDefinitions = [];

    public function __construct() {
        $this->configure();
    }
    /**
     * @param $name
     * @return null|ServiceConfig
     */
    public function getServiceConfigByName($name) {
        if(isset($this->serviceDefinitions[$name])) {
            return $this->serviceDefinitions[$name];
        }

        return null;
    }

    /**
     * @param ContainerConfig $containerConfig
     * @return void
     */
    public function merge(ContainerConfig $containerConfig)
    {
        $this->serviceDefinitions = array_merge($this->serviceDefinitions, $containerConfig->getServiceDefinitions());
    }

    /**
     * @return array
     */
    public function getServiceDefinitions(): array
    {
        return $this->serviceDefinitions;
    }

    /**
     * Method to define the ServicConfig objects for the config class
     *
     * @return mixed
     */
    abstract protected function configure();
}