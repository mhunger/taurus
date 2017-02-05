<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 15/01/17
 * Time: 17:55
 */

namespace taurus\framework\db\mysql;

use taurus\framework\db\DbConnection;
use taurus\framework\db\query\InsertQuery;
use taurus\framework\db\query\Query;
use taurus\framework\db\query\QueryStringBuilder;

/**
 * Class MySqlConnection
 * @package taurus\framework\db
 *
 * wrapper for the mysqli class
 */
class MySqlConnection implements DbConnection {

    /** @var mysqli */
    private $mysqli;

    /** @var QueryStringBuilder */
    private $queryStringBuilder;
    /**
     * @param $host
     * @param $user
     * @param $password
     * @param $database
     * @param QueryStringBuilder $queryStringBuilder
     */
    function __construct($host, $user, $password, $database, QueryStringBuilder $queryStringBuilder)
    {
        try{
            $this->mysqli = new \mysqli($host, $user, $password, $database);
        } catch(\Exception $e) {
            print_r($e);
        }

        $this->queryStringBuilder = $queryStringBuilder;
    }

    /**
     * @param $sql
     * @return mixed|\mysqli_result
     */
    public function executeRaw($sql) {
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
        $result = $this->executeRaw($sql);

        $objects = [];
        try{
            if ($result) {
                while ($row = $result->fetch_object($class)) {
                    $objects[] = $row;
                }
            }
        } catch(\Exception $e) {
            print_r($e);
        }
        return $objects;
    }

    /**
     * @param Query $query
     * @param null $class
     * @return array
     */
    public function execute(Query $query, $class = null)
    {
        return $this->fetchObjects(
            $this->queryStringBuilder->getSelectQueryString($query),
            $class
        );
    }

    /**
     * @param InsertQuery $insertQuery
     * @return mixed|\mysqli_result
     */
    public function insert(InsertQuery $insertQuery) {
        return $this->executeRaw(
            $this->queryStringBuilder->getInsertQueryString(
                $insertQuery
            )
        );
    }
}
