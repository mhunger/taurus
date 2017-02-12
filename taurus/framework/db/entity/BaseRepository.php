<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 16/12/16
 * Time: 14:11
 */

namespace taurus\framework\db\entity;

use taurus\framework\db\Entity;
use taurus\framework\db\query\expression\ComparisonExpression;
use taurus\framework\db\query\expression\Field;
use taurus\framework\db\query\expression\Literal;
use taurus\framework\db\query\operation\Equals;
use taurus\framework\db\query\QueryBuilder;
use taurus\framework\Environment;

/**
 * Class BaseRepository
 * @package taurus\framework\db\entity
 */
class BaseRepository {

    /** @var QueryBuilder */
    private $qb;

    /** @var EntityMetaDataWrapper */
    private $entityMetaData;

    /** @var EntityAccessLayer */
    private $entityAccessLayer;

    /**
     * @param QueryBuilder $queryBuilder
     * @param EntityMetaDataWrapper $entityMetaData
     * @param EntityAccessLayer $entityAccessLayer
     */
    function __construct(
        QueryBuilder $queryBuilder,
        EntityMetaDataWrapper $entityMetaData,
        EntityAccessLayer $entityAccessLayer
    )
    {
        $this->qb = $queryBuilder;
        $this->entityMetaData = $entityMetaData;
        $this->entityAccessLayer = $entityAccessLayer;
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

        return $this->entityAccessLayer->fetchOne($q, $entityClass);
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

        return $this->entityAccessLayer->fetchMany($q, $entityClass);
    }

    /**
     * @param Entity $entity
     */
    public function save(Entity $entity) {
        $q = $this->qb->query(QueryBuilder::QUERY_TYPE_INSERT)
            ->insertInto(
                $this->entityMetaData->getTable(get_class($entity)),
                $this->entityMetaData->getColumns(get_class($entity))
            )->values(
                $this->entityMetaData->getColumnValues($entity)
            );

        $this->entityAccessLayer->insert($q, get_class($entity));
    }

    public function delete(Entity $entity)
    {
        $q = $this->qb->query(QueryBuilder::QUERY_TYPE_DELETE)
            ->deleteFrom(
                $this->entityMetaData->getTable(get_class($entity))
            )->where(
                $this->entityMetaData->getIdField(get_class($entity)),
                [$this->entityMetaData->getIdValue($entity)]
            );

        $this->entityAccessLayer->delete($q);
    }
}
