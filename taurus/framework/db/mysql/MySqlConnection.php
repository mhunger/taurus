<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 15/01/17
 * Time: 17:55
 */

namespace taurus\framework\db\mysql;

use taurus\framework\db\DbConnection;
use taurus\framework\db\query\DeleteQuery;
use taurus\framework\db\query\InsertQuery;
use taurus\framework\db\query\Query;
use taurus\framework\db\query\QueryStringBuilder;
use taurus\framework\db\query\UpdateQuery;
use taurus\framework\error\MysqlQueryException;

/**
 * Class MySqlConnection
 * @package taurus\framework\db
 *
 * wrapper for the mysqli class
 */
class MySqlConnection implements DbConnection {

    /** @var \mysqli */
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
     * @param DeleteQuery $deleteQuery
     * @return bool|\mysqli_result
     */
    public function delete(DeleteQuery $deleteQuery)
    {
        $sql = $this->queryStringBuilder->getDeleteQueryString($deleteQuery);

        return $this->executeRaw($sql);
    }

    /**
     * @param $sql
     * @return bool|\mysqli_result
     * @throws MysqlQueryException
     */
    public function executeRaw($sql) {
        if($result = $this->mysqli->query($sql)) {
            return $result;
        }

        throw new MysqlQueryException($sql);
    }


    /**
     * @param $sql
     * @return array
     */
    public function fetchResultsAsArray($sql)
    {
        /** @var \mysqli_result */
        $result = $this->executeRaw($sql);

        $results = [];
        try{
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $results[] = $row;
                }
            }
        } catch(\Exception $e) {
            print_r($e);
        }

        return $results;
    }

    /**
     * @param Query $query
     * @return array
     */
    public function executeMany(Query $query)
    {
        return $this->fetchResultsAsArray(
            $this->queryStringBuilder->getSelectQueryString($query)
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

    /**
     * @param Query $query
     * @return mixed
     */
    public function executeOne(Query $query)
    {
        $result = $this->executeMany($query);

        if (count($result) > 0) {
            return $result[0];
        }
    }

    /**
     * @param UpdateQuery $updateQuery
     * @return bool|\mysqli_result
     */
    public function update(UpdateQuery $updateQuery)
    {
        return $this->executeRaw(
            $this->queryStringBuilder->getDeleteQueryString($updateQuery)
        );
    }
}
