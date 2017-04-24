<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 06/03/17
 * Time: 23:18
 */

namespace taurus\framework\db\entity;

use taurus\framework\annotation\OneToOne;
use taurus\framework\db\query\expression\ComparisonExpression;
use taurus\framework\db\query\expression\Field;
use taurus\framework\db\query\expression\Literal;
use taurus\framework\db\query\operation\Equals;
use taurus\framework\db\query\QueryBuilder;
use taurus\framework\db\query\SelectQuery;

class OneToOneBuilder
{
    /** @var EntityMetaDataImpl */
    private $entityMetaDataImpl;

    /** @var QueryBuilder */
    private $queryBuilder;

    /**
     * OneToOneBuilder constructor.
     * @param EntityMetaDataImpl $entityMetaDataImpl
     * @param QueryBuilder $queryBuilder
     */
    public function __construct(EntityMetaDataImpl $entityMetaDataImpl, QueryBuilder $queryBuilder)
    {
        $this->entityMetaDataImpl = $entityMetaDataImpl;
        $this->queryBuilder = $queryBuilder;
    }

    /**
     * @param OneToOne $relationship
     * @param int $id
     * @return SelectQuery
     */
    public function build(OneToOne $relationship, int $id): SelectQuery
    {
        $q = $this->queryBuilder->query(QueryBuilder::QUERY_TYPE_SELECT)
            ->select()
            ->from($relationship->getReferenceTable())
            ->where(
                new ComparisonExpression(
                    new Field($relationship->getReferenceTableField()),
                    new Equals(),
                    new Literal($id)
                )
            );

        return $q;
    }
}