<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 15/01/17
 * Time: 17:55
 */

namespace taurus\framework\db;

/**
 * Class MySqlConnection
 * @package taurus\framework\db
 *
 * wrapper for the mysqli class
 */
class MySqlConnection {

    /** @var mysqli */
    private $mysqli;

    /**
     * @param $host
     * @param $user
     * @param $password
     * @param $database
     */
    function __construct($host, $user, $password, $database)
    {
        try{
            $this->mysqli = new \mysqli($host, $user, $password, $database);
        } catch(\Exception $e) {
            print_r($e);
        }
    }
}
