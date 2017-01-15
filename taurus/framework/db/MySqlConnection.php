<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 15/01/17
 * Time: 17:55
 */

namespace taurus\framework\db;

use fitnessmanager\workout\Workout;

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

    /**
     * @param $sql
     * @return mixed|\mysqli_result
     */
    public function execute($sql) {
        if($result = $this->mysqli->query($sql)) {
            return $result;
        }
    }

    /**
     * @param $sql
     * @param null $class
     * @return array
     */
    public function fetchObjects($sql, $class = null) {
        /** @var \mysqli_result */
        $result = $this->execute($sql);

        $objects = [];
        try{
            while($row = $result->fetch_object($class)) {
                $objects[] = $row;
            }
        } catch(\Exception $e) {
            print_r($e);
        }
        return $objects;
    }
}
