<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 21/05/17
 * Time: 16:11
 */

namespace taurus\framework\page;


class AppConfig
{

    /** @var array */
    protected $config;

    /**
     * AppConfig constructor.
     */
    public function __construct()
    {
        $this->config = json_decode(file_get_contents(dirname( __FILE__) . '/pageConfig.json'));

    }

    public function getMenu()
    {
        return $this->config->menu;
    }

    public function getMenuItems() {
        return $this->config->menu->menuItems;
    }
}
