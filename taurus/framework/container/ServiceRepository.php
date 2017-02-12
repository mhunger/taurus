<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 12/02/17
 * Time: 12:19
 */

namespace taurus\framework\container;


/**
 * Class ServiceRepository
 * @package taurus\framework\container
 */
/**
 * Class ServiceRepository
 * @package taurus\framework\container
 */
class ServiceRepository
{
    /**
     * @var array
     */
    private $servicesLoaded = [];


    /**
     * @param $serviceName
     * @param object $service
     * @return mixed
     */
    public function getExistingOrAddAndReturnSingleton($serviceName, $service)
    {
        if (!isset($this->servicesLoaded[$serviceName])) {
            $this->servicesLoaded[$serviceName] = $service;
        }

        return $this->servicesLoaded[$serviceName];
    }

    /**
     * @param $serviceName
     * @return object|null
     */
    public function getServiceByName($serviceName)
    {
        if (isset($this->servicesLoaded[$serviceName])) {
            return $this->servicesLoaded[$serviceName];
        }

        return null;
    }
}
