<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 23/04/17
 * Time: 19:33
 */

namespace taurus\framework\db\entity;

use taurus\framework\annotation\OneToMany;
use taurus\framework\db\query\expression\ConditionalExpression;
use taurus\framework\db\query\expression\Field;
use taurus\framework\db\query\expression\Literal;
use taurus\framework\db\query\operation\Equals;
use taurus\framework\db\query\QueryBuilder;
use taurus\framework\db\query\SelectQuery;

class OneToManyBuilder
{
    /** @var EntityMetaDataWrapper */
    private $entityMetaDataWrapper;

    /** @var QueryBuilder */
    private $querybuilder;

    /**
     * OneToManyBuilder constructor.
     * @param EntityMetaDataImpl $entityMetaDataImpl
     * @param QueryBuilder $queryBuilder
     */
    public function __construct(EntityMetaDataImpl $entityMetaDataImpl, QueryBuilder $queryBuilder)
    {
        $this->entityMetaDataWrapper = $entityMetaDataImpl;
        $this->querybuilder = $queryBuilder;
    }

    /**
     * @param OneToMany $oneToMany
     * @param mixed $foreignKeyValue
     * @return SelectQuery
     */
    public function build(OneToMany $oneToMany, int $foreignKeyValue): SelectQuery {
        $q = $this->querybuilder->query(QueryBuilder::QUERY_TYPE_SELECT)
            ->select()
            ->from($oneToMany->getReferenceTable())
            ->where(
                new ConditionalExpression(
                    new Field($oneToMany->getForeignKeyField()),
                    new Equals(),
                    new Literal($foreignKeyValue)
                )
            );
        return $q;
    }
}
