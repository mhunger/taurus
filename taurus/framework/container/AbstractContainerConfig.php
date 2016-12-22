<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 21/12/16
 * Time: 19:48
 */

namespace taurus\framework\container;


class AbstractContainerConfig implements ContainerConfig{

    /** @var array */
    protected $serviceDefinitions = [];

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
    public function getServiceDefinitions()
    {
        return $this->serviceDefinitions;
    }
}