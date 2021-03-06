<?php

namespace bin\tpl;

/**
 * Created by PhpStorm.
 * User: michael_hunger
 * Date: 07/07/17
 * Time: 09:26
 */
class ConfigFileTemplateData
{

    private $basePath;

    private $appname;

    private $routeConfigClass;

    private $dbhost;

    private $dbuser;

    private $dbpw;

    private $db;

    private $containerClass;

    private $testContainerClass;

    /**
     * ConfigFileTemplateData constructor.
     * @param $basePath
     * @param $appname
     * @param $routeConfigClass
     * @param $dbhost
     * @param $dbuser
     * @param $dbpw
     * @param $db
     * @param $containerClass
     * @param $testContainerClass
     */
    public function __construct($basePath, $appname, $routeConfigClass, $dbhost, $dbuser, $dbpw, $db, $containerClass, $testContainerClass)
    {
        $this->basePath = $basePath;
        $this->appname = $appname;
        $this->routeConfigClass = $routeConfigClass;
        $this->dbhost = $dbhost;
        $this->dbuser = $dbuser;
        $this->dbpw = $dbpw;
        $this->db = $db;
        $this->containerClass = $containerClass;
        $this->testContainerClass = $testContainerClass;
    }

    public function getVars() {
        return [
            TaurusInitiator::basePath => $this->basePath,
            TaurusInitiator::appname => $this->appname,
            TaurusInitiator::route_config_class => $this->routeConfigClass,
            TaurusInitiator::dbhost => $this->dbhost,
            TaurusInitiator::dbuser => $this->dbuser,
            TaurusInitiator::dbpw => $this->dbpw,
            TaurusInitiator::db => $this->db,
            TaurusInitiator::app_container_class => $this->containerClass,
            TaurusInitiator::app_test_container_class => $this->testContainerClass
        ];
    }

    /**
     * @return mixed
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * @return mixed
     */
    public function getAppname()
    {
        return $this->appname;
    }

    /**
     * @return mixed
     */
    public function getRouteConfigClass()
    {
        return $this->routeConfigClass;
    }

    /**
     * @return mixed
     */
    public function getDbhost()
    {
        return $this->dbhost;
    }

    /**
     * @return mixed
     */
    public function getDbuser()
    {
        return $this->dbuser;
    }

    /**
     * @return mixed
     */
    public function getDbpw()
    {
        return $this->dbpw;
    }

    /**
     * @return mixed
     */
    public function getDb()
    {
        return $this->db;
    }

    /**
     * @return mixed
     */
    public function getContainerClass()
    {
        return $this->containerClass;
    }

    /**
     * @return mixed
     */
    public function getTestContainerClass()
    {
        return $this->testContainerClass;
    }

}