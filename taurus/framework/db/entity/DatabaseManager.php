<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 15/01/17
 * Time: 17:52
 */

namespace taurus\framework\db\entity;

use taurus\framework\annotation\OneToOne;
use taurus\framework\db\DbConnection;
use taurus\framework\db\Entity;
use taurus\framework\db\EntityBuilder;
use taurus\framework\db\query\DeleteQuery;
use taurus\framework\db\query\InsertQuery;
use taurus\framework\db\query\Query;
use taurus\framework\db\query\QueryBuilder;
use taurus\framework\db\query\UpdateQuery;

/**
 * Class DatabaseManager
 * @package taurus\framework\db\entity
 */
class DatabaseManager implements EntityAccessLayer
{

    /** @var DbConnection */
    private $dbConnection;

    /** @var EntityBuilder */
    private $entityBuilder;

    /** @var EntityMetaDataImpl */
    private $entityMetaDataImpl;

    /** @var OneToOneBuilder */
    private $oneToOneBuilder;
    /**
     * DatabaseManager constructor.
     * @param DbConnection $dbConnection
     * @param EntityBuilder $entityBuilder
     * @param EntityMetaDataImpl $entityMetaDataImpl
     */
    function __construct(DbConnection $dbConnection, EntityBuilder $entityBuilder, EntityMetaDataImpl $entityMetaDataImpl, OneToOneBuilder $oneToOneBuilder)
    {
        $this->dbConnection = $dbConnection;
        $this->entityBuilder = $entityBuilder;
        $this->entityMetaDataImpl = $entityMetaDataImpl;
        $this->oneToOneBuilder = $oneToOneBuilder;
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
    public function fetchMany(Query $query, $class): array
    {
        $result = $this->dbConnection->executeMany($query);

        $entities = [];
        foreach($result as $row) {
            $relationshipData = $this->fetchDependenciesForClass($class, $row[$this->entityMetaDataImpl->getIdField($class)]);
            $entities[] = $this->entityBuilder->convertOne($row, $class, $relationshipData);
        }

        return $entities;
    }

    /**
     * @param Query $query
     * @param string $class
     * @param $id
     * @return null|Entity
     */
    public function fetchOne(Query $query, string $class, int $id)
    {
        $result = $this->dbConnection->executeOne($query);

        if (is_null($result) || count($result) == 0) {
            return null;
        }

        $relationshipData = $this->fetchDependenciesForClass($class, $id);
        return $this->entityBuilder->convertOne($result, $class, $relationshipData);
    }

    /**
     * @param string $class
     * @param $id
     * @return array
     */
    private function fetchDependenciesForClass(string $class, $id)
    {
        $rels = $this->entityMetaDataImpl->getRelationships($class);

        $result = [];
        foreach($rels as $property => $annotation) {
            switch(get_class($annotation)) {
                case OneToOne::class:
                    $result[$annotation->getColumn()] = $this->entityBuilder
                    ->convertOne(
                        $this->dbConnection->executeOne(
                            $this->oneToOneBuilder->build($annotation, $id)
                        ),
                        $annotation->getEntity()
                    );

                    break;
            }
        }

        return $result;
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
