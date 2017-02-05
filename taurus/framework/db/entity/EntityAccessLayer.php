<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 05/02/17
 * Time: 21:06
 */

namespace taurus\framework\db\entity;


use taurus\framework\db\Entity;
use taurus\framework\db\query\InsertQuery;
use taurus\framework\db\query\Query;

interface EntityAccessLayer
{

    /**
     * @param Entity $entity
     * @return mixed
     */
    public function update(Entity $entity);

    /**
     * @param Entity $entity
     * @return mixed
     */
    public function delete(Entity $entity);

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
    public function insert(InsertQuery $query);
}
