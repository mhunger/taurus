<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 21/12/16
 * Time: 19:37
 */

namespace taurus\framework\container;


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
     * @return mixed|ServiceConfig
     */
    public function getServiceConfigByName($name);

    /**
     * Merge two configurations into one. The configuration passed will be merged into the one on which the method is called. This is done
     * by merging the service definitions array inside the objects. Service defined in both will be unified
     *
     * @param ContainerConfig $containerConfig
     * @return ContainerConfig
     */
    public function merge(ContainerConfig $containerConfig): ContainerConfig;

    /**
     * Return the service definitions for this configuration as array
     *
     * @return mixed
     */
    public function getServiceDefinitions(): array;
}