<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 15/01/17
 * Time: 17:52
 */

namespace taurus\framework\db\entity;

use fitnessmanager\workout\Workout;
use taurus\framework\db\DbConnection;
use taurus\framework\db\Entity;
use taurus\framework\db\entity\BaseRepository;
use taurus\framework\db\EntityBuilder;
use taurus\framework\db\mysql\MySqlConnection;
use taurus\framework\db\query\InsertQuery;
use taurus\framework\db\query\Query;

/**
 * Class DatabaseManager
 * @package taurus\framework\db\entity
 */
class DatabaseManager implements EntityAccessLayer
{

    /** @var MysqlConnection */
    private $dbConnection;

    /** @var EntityBuilder */
    private $entityBuilder;


    /**
     * @param DbConnection $dbConnection
     * @param EntityBuilder $entityBuilder
     */
    function __construct(DbConnection $dbConnection, EntityBuilder $entityBuilder)
    {
        $this->dbConnection = $dbConnection;
        $this->entityBuilder = $entityBuilder;
    }

    /**
     * @param Entity $entity
     * @return mixed
     */
    public function update(Entity $entity)
    {
        // TODO: Implement update() method.
    }

    /**
     * @param Entity $entity
     * @return mixed
     */
    public function delete(Entity $entity)
    {
        // TODO: Implement delete() method.
    }

    /**
     * @param Query $query
     * @param null $class
     * @return array
     */
    public function fetchMany(Query $query, $class = null)
    {
        return $this->dbConnection->executeMany($query, $class);
    }

    /**
     * @param Query $query
     * @param null $class
     * @return Entity
     */
    public function fetchOne(Query $query, $class = null)
    {
        $result = $this->dbConnection->executeOne($query, $class);

        return $this->entityBuilder->convertOne($result, $class);
    }

    /**
     * @param InsertQuery $query
     * @return mixed
     */
    public function insert(InsertQuery $query)
    {
        return $this->dbConnection->insert($query);
    }
}
