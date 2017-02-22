<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 05/02/17
 * Time: 21:06
 */

namespace taurus\framework\db\entity;


use taurus\framework\db\Entity;
use taurus\framework\db\query\DeleteQuery;
use taurus\framework\db\query\InsertQuery;
use taurus\framework\db\query\Query;
use taurus\framework\db\query\UpdateQuery;

interface EntityAccessLayer
{

    /**
     * @param UpdateQuery $updateQuery
     * @return mixed
     */
    public function update(UpdateQuery $updateQuery);

    /**
     * @param string|DeleteQuery $deleteQuery
     * @return mixed
     */
    public function delete(DeleteQuery $deleteQuery);

    /**
     * @param Query $query
     * @param null $class
     * @return mixed
     */
    public function fetchMany(Query $query, $class = null);

    /**
     * @param Query $query
     * @param null $class
     * @return mixed
     */
    public function fetchOne(Query $query, $class = null);

    /**
     * @param InsertQuery $query
     * @return mixed
     */
    public function insert(InsertQuery $query): bool;
}
