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

    /** @var EntityMetaData */
    private $entityMetaData;

    /** @var DbConnection */
    private $dbConnection;

    /**
     * @param QueryBuilder $queryBuilder
     * @param EntityMetaData $entityMetaData
     * @param DbConnection $dbConnection
     */
    function __construct(QueryBuilder $queryBuilder, EntityMetaData $entityMetaData, DbConnection $dbConnection)
    {
        $this->qb = $queryBuilder;
        $this->entityMetaData = $entityMetaData;
        $this->dbConnection = $dbConnection;
    }

    /**
     * @param $id
     */
    public function findOne($id){
        $q = $this->qb->query()
            ->select()
            ->from(
                $this->entityMetaData->getTable()
            )->where(
                new ConditionalExpression(
                    new ComparisonExpression(
                        new Field(
                            $this->entityMetaData->getIdField()
                        ),
                        new Equals(),
                        new Literal($id)
                    ),
                    new AndOperation(),
                    new ComparisonExpression(
                        new Field('date'),
                        new Equals(),
                        new Literal('2016-01-01')
                    )
                )
            );
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