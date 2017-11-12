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
use taurus\framework\db\query\expression\ExpressionBuilder;
use taurus\framework\db\query\expression\Field;
use taurus\framework\db\query\expression\Literal;
use taurus\framework\db\query\operation\Equals;
use taurus\framework\db\query\QueryBuilder;
use taurus\framework\db\query\Specification;

/**
 * Class BaseRepository
 * @package taurus\framework\db\entity
 */
class BaseRepository
{

    /** @var QueryBuilder */
    private $qb;

    /** @var EntityMetaDataWrapper */
    private $entityMetaData;

    /** @var EntityAccessLayer */
    private $entityAccessLayer;

    /** @var ExpressionBuilder */
    private $expressionBuilder;

    /**
     * BaseRepository constructor.
     * @param QueryBuilder $qb
     * @param EntityMetaDataWrapper $entityMetaData
     * @param EntityAccessLayer $entityAccessLayer
     * @param ExpressionBuilder $expressionBuilder
     */
    public function __construct(
        QueryBuilder $qb,
        EntityMetaDataWrapper $entityMetaData,
        EntityAccessLayer $entityAccessLayer,
        ExpressionBuilder $expressionBuilder
    ) {
        $this->qb = $qb;
        $this->entityMetaData = $entityMetaData;
        $this->entityAccessLayer = $entityAccessLayer;
        $this->expressionBuilder = $expressionBuilder;
    }

    /**
     * @param $id
     * @param $entityClass
     * @return Entity|null
     */
    public function findOne($id, $entityClass)
    {
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


        return $this->entityAccessLayer->fetchOne($q, $entityClass, $id);
    }

    /**
     * @param $entityClass
     * @param int $page
     * @param int $pageSize
     * @return array
     * @internal param $int $
     * @internal param int $offset
     * @internal param int $limit
     */
    public function findAll($entityClass, int $page = 1, int $pageSize = null): array
    {
        $q = $this->qb->query(QueryBuilder::QUERY_TYPE_SELECT)
            ->select()
            ->from(
                $this->entityMetaData->getTable($entityClass)
            )->limit(
                $this->getOffsetFromPageAndPageSize($page, $pageSize),
                $pageSize
            );

        return $this->entityAccessLayer->fetchMany($q, $entityClass);
    }

    /**
     * @param Entity $entity
     * @return bool
     */
    public function save(Entity $entity): bool
    {
        $q = $this->qb->query(QueryBuilder::QUERY_TYPE_INSERT)
            ->insertInto(
                $this->entityMetaData->getTable(get_class($entity)),
                $this->entityMetaData->getColumns(get_class($entity))
            )->values(
                $this->entityMetaData->getColumnValues($entity)
            );

        return $this->entityAccessLayer->insert($q);
    }

    /**
     * @param Entity $entity
     */
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

    /**
     * @param Entity $entity
     * @return mixed
     */
    public function update(Entity $entity)
    {
        $q = $this->qb->query(QueryBuilder::QUERY_TYPE_UPDATE)
            ->update(
                $this->entityMetaData->getTable(get_class($entity))
            )
            ->set(
                $this->entityMetaData->getColumnNameValueMap($entity)
            )
            ->where(
                $this->entityMetaData->getIdField(get_class($entity)),
                $this->entityMetaData->getIdValue($entity)
            );

        return $this->entityAccessLayer->update($q);
    }

    /**
     * @param Specification $specification
     * @param string $entityClass
     * @param int $page
     * @param int $pageSize
     * @return array
     */
    public function findBySpecification(
        Specification $specification,
        string $entityClass,
        int $page = 1,
        int $pageSize = null
    ): array {
        $q = $this->qb->query(QueryBuilder::QUERY_TYPE_SELECT)
            ->select()
            ->from($specification->getTable())
            ->where(
                $this->expressionBuilder->build($specification)
            )->limit(
                $this->getOffsetFromPageAndPageSize($page, $pageSize),
                $pageSize
            );

        return $this->entityAccessLayer->fetchMany($q, $entityClass);
    }

    /**
     * @param int $page
     * @param int $pageSize
     * @return int
     */
    private function getOffsetFromPageAndPageSize(int $page, int $pageSize = null)
    {
        if($pageSize === null) {
            return 0;
        }

        return ($page - 1) * $pageSize;
    }
}
