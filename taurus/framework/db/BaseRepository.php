<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 16/12/16
 * Time: 14:11
 */

namespace taurus\framework\db;

use taurus\framework\db\query\expression\Field;
use taurus\framework\db\query\expression\Number;
use taurus\framework\db\query\Query;
use taurus\framework\db\query\QueryBuilder;

class BaseRepository {

    /** @var QueryBuilder */
    private $queryBuilder;

    /** @var EntityMetaData */
    private $entityMetaData;

    /**
     * @param QueryBuilder $queryBuilder
     * @param EntityMetaData $entityMetaData
     */
    function __construct(QueryBuilder $queryBuilder, EntityMetaData $entityMetaData)
    {
        $this->queryBuilder = $queryBuilder;
        $this->entityMetaData = $entityMetaData;
    }

    /**
     * @param $id
     */
    public function findOne($id){
        $this->queryBuilder->query()
            ->select()
            ->from(
                $this->entityMetaData->getTable()
            )
            ->where(
                $this->entityMetaData->getIdField()
            )
            ->isEqualTo($id)
            ->andWhere('date')
            ->isEqualTo('2016-01-01');
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