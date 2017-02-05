<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 20/01/17
 * Time: 22:47
 */

namespace taurus\framework\db;


use taurus\framework\db\query\Query;

/**
 * Abstraction for any db interaction. It should be implemented by specifc storage layer classes that will adapt the
 * specific mechanics of that storage. the queries should be build with special query builder classes
 * that take in QAL objects and build query strings from it
 *
 * Interface DbConnection
 * @package taurus\framework\db
 */
interface DbConnection {

    /**
     * @param $sql
     * @param null $class
     * @return mixed
     */
    public function fetchObjects($sql, $class = null);

    /**
     * @param $sql
     * @return mixed
     */
    public function executeRaw($sql);

    /**
     * @param Query $query
     * @param null $class
     * @return mixed
     */
    public function execute(Query $query, $class = null);

    /**
     * @param Query $query
     * @return mixed
     */
    public function insert(Query $query);
}