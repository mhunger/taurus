<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 16/12/16
 * Time: 14:11
 */

namespace taurus\framework\db\entity;

use taurus\framework\db\DbConnection;
use taurus\framework\db\Entity;
use taurus\framework\db\entity\EntityMetaDataWrapper;
use taurus\framework\db\query\expression\ComparisonExpression;
use taurus\framework\db\query\expression\ConditionalExpression;
use taurus\framework\db\query\expression\Field;
use taurus\framework\db\query\expression\Literal;
use taurus\framework\db\query\expression\Number;
use taurus\framework\db\query\operation\AndOperation;
use taurus\framework\db\query\operation\Equals;
use taurus\framework\db\query\Query;
use taurus\framework\db\query\QueryBuilder;

/**
 * Class BaseRepository
 * @package taurus\framework\db\entity
 */
class BaseRepository {

    /** @var QueryBuilder */
    private $qb;

    /** @var EntityMetaDataWrapper */
    private $entityMetaData;

    /** @var DbConnection */
    private $dbConnection;

    /**
     * @param QueryBuilder $queryBuilder
     * @param EntityMetaDataWrapper $entityMetaData
     * @param DbConnection $dbConnection
     */
    function __construct(QueryBuilder $queryBuilder, EntityMetaDataWrapper $entityMetaData, DbConnection $dbConnection)
    {
        $this->qb = $queryBuilder;
        $this->entityMetaData = $entityMetaData;
        $this->dbConnection = $dbConnection;
    }

    /**
     * @param $id
     * @param $entityClass
     * @return Entity|null
     */
    public function findOne($id, $entityClass) {
        $q = $this->qb->query(QueryBuilder::QUERY_TYPE_SELECT)
            ->select()
            ->from(
                $this->entityMetaData->getTable($entityClass)
            )->where(
                new ComparisonExpression(
                    new Field(
                        $this->entityMetaData->getIdField($entityClass)
                    ),
                    new Equals(),
                    new Literal($id)
                )
            );

        return $this->dbConnection->execute($q, $entityClass);
    }

    /**
     * @param $entityClass
     * @return mixed
     */
    public function findAll($entityClass)
    {
        $q = $this->qb->query(QueryBuilder::QUERY_TYPE_SELECT)
            ->select()
            ->from(
                $this->entityMetaData->getTable($entityClass)
            );

        return $this->dbConnection->execute($q, $entityClass);
    }

    /**
     * @param Entity $entity
     */
    public function save(Entity $entity) {
        $q = $this->qb->query(QueryBuilder::QUERY_TYPE_INSERT)
            ->insertInto(
                $this->entityMetaData->getTable($entity),
                $this->entityMetaData->getColumns($entity)
            )->values(
                $this->entityMetaData->getColumnValues($entity)
            );

        $this->dbConnection->execute($q, get_class($entity));
    }
}
