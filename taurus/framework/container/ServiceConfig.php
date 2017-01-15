<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 21/12/16
 * Time: 18:48
 */

namespace taurus\framework\container;

use taurus\framework\error\ServiceParameterNotFoundInConfigException;

/**
 * Class that stores the configuration for one specific service e.g. to inject literal parameters
 *
 * Class ServiceConfig
 * @package taurus\framework\container
 */
class ServiceConfig {

    /** @var string */
    private $class;

    /** @var string */
    private $name;

    /** @var array */
    private $parameters;

    /** @var bool */
    private $singleton;

    /**
     * @param $class
     * @param $name
     * @param $parameters
     * @param bool $singleton
     */
    public function __construct($class, $name, $parameters, $singleton = false) {
        $this->class = $class;
        $this->name = $name;
        $this->parameters = $parameters;
        $this->singleton = $singleton;
    }

    /**
     * @param $position
     * @return mixed
     * @throws ServiceParameterNotFoundInConfigException
     */
    public function getParameterByPosition($position) {
        if(isset($this->parameters[$position])) {
            return $this->parameters[$position];
        }

        throw new ServiceParameterNotFoundInConfigException();
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return boolean
     */
    public function isSingleton()
    {
        return $this->singleton;
    }
}

