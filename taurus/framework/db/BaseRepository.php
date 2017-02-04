<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 16/12/16
 * Time: 14:11
 */

namespace taurus\framework\db;

use taurus\framework\db\query\expression\ComparisonExpression;
use taurus\framework\db\query\expression\ConditionalExpression;
use taurus\framework\db\query\expression\Field;
use taurus\framework\db\query\expression\Literal;
use taurus\framework\db\query\expression\Number;
use taurus\framework\db\query\operation\AndOperation;
use taurus\framework\db\query\operation\Equals;
use taurus\framework\db\query\Query;
use taurus\framework\db\query\QueryBuilder;

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
     * @return mixed
     */
    public function findOne($id, $entityClass) {
        $q = $this->qb->query()
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
     *
     */
    public function findAll() {

    }

    /**
     *
     */
    public function findByName() {

    }
}
