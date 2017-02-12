<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 20/01/17
 * Time: 22:47
 */

namespace taurus\framework\db;


use taurus\framework\db\query\DeleteQuery;
use taurus\framework\db\query\InsertQuery;
use taurus\framework\db\query\Query;
use taurus\framework\db\query\UpdateQuery;

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
     * @return mixed
     */
    public function fetchResultsAsArray($sql);

    /**
     * @param $sql
     * @return mixed
     */
    public function executeRaw($sql);

    /**
     * @param Query $query
     * @return mixed
     */
    public function executeMany(Query $query);


    /**
     * @param Query $query
     * @return mixed
     */
    public function executeOne(Query $query);

    /**
     * @param InsertQuery $query
     * @return mixed
     */
    public function insert(InsertQuery $query);


    /**
     * @param DeleteQuery $deleteQuery
     * @return mixed
     */
    public function delete(DeleteQuery $deleteQuery);

    /**
     * @param UpdateQuery $updateQuery
     * @return mixed
     */
    public function update(UpdateQuery $updateQuery);
}
