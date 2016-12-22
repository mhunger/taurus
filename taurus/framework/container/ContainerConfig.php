<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 21/12/16
 * Time: 19:37
 */

namespace taurus\framework\container;

use taurus\framework\routing\RouteConfig;
use taurus\framework\routing\Request;
use taurus\framework\mock\MockServer;

/**
 * Interface to implement for different configurations in different contexts, environments. Should enable to savely extend Configuration
 * in different situations without having to touch the core or app config
 *
 * Interface ContainerConfig
 * @package taurus\framework\container
 */
interface ContainerConfig {

    /**
     * Return the service definition for the service with name $name. Currently name is the full clath path with namespace
     * @param $name
     * @return mixed
     */
    public function getServiceConfigByName($name);

    /**
     * Merge two configurations into one. The configuration passed will be merged into the one on which the method is called. This is done
     * by merging the service definitions array inside the objects. Service defined in both will be unified
     *
     * @param ContainerConfig $containerConfig
     * @return mixed
     */
    public function merge(ContainerConfig $containerConfig);

    /**
     * Return the service definitions for this configuration as array
     *
     * @return mixed
     */
    public function getServiceDefinitions();
}