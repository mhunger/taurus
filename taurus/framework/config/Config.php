<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 15/10/17
 * Time: 22:22
 */

namespace taurus\framework\config;


/**
 * Interface Config
 * @package taurus\framework\config
 */
interface Config
{
    /**
     * @param string $name
     * @return mixed
     */
    public function getConfig(string $name);
}
