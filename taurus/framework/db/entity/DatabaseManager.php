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
use taurus\framework\db\query\DeleteQuery;
use taurus\framework\db\query\InsertQuery;
use taurus\framework\db\query\Query;
use taurus\framework\db\query\UpdateQuery;

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
     * @param UpdateQuery $updateQuery
     * @return bool|mixed|\mysqli_result
     */
    public function update(UpdateQuery $updateQuery)
    {
        return $this->dbConnection->update($updateQuery);
    }

    /**
     * @param DeleteQuery $deleteQuery
     * @return bool|mixed|\mysqli_result
     */
    public function delete(DeleteQuery $deleteQuery)
    {
        return $this->dbConnection->delete($deleteQuery);
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

        if (is_null($result) || count($result) == 0) {
            return null;
        }

        return $this->entityBuilder->convertOne($result, $class);
    }

    /**
     * @param InsertQuery $query
     * @return bool
     */
    public function insert(InsertQuery $query): bool
    {
        return $this->dbConnection->insert($query);
    }
}
