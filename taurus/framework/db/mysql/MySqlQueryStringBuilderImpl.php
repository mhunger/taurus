<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 27/01/17
 * Time: 19:23
 */

namespace taurus\framework\db\mysql;


use taurus\framework\db\query\expression\Expression;
use taurus\framework\db\query\expression\MultiPartExpression;
use taurus\framework\db\query\InsertQuery;
use taurus\framework\db\query\InsertQueryStringBuilder;
use taurus\framework\db\query\QueryStringBuilder;
use taurus\framework\db\query\SelectQuery;
use taurus\framework\db\query\Condition;
use taurus\framework\db\query\BooleanExpression;
use taurus\framework\db\query\SelectQueryStringBuilder;

class MySqlQueryStringBuilderImpl implements QueryStringBuilder
{
    /** @var SelectQueryStringBuilder */
    private $selectQueryStringBuilder;

    /** @var InsertQueryStringBuilder */
    private $insertQueryStringBuilder;

    /**
     * @param SelectQueryStringBuilder $selectQueryStringBuilder
     * @param InsertQueryStringBuilder $insertQueryStringBuilder
     */
    function __construct(
        SelectQueryStringBuilder $selectQueryStringBuilder,
        InsertQueryStringBuilder $insertQueryStringBuilder
    ) {
        $this->selectQueryStringBuilder = $selectQueryStringBuilder;
        $this->insertQueryStringBuilder = $insertQueryStringBuilder;
    }

    /**
     * Return the mysql query string given a select query
     *
     * @param SelectQuery $selectQuery
     * @return string
     */
    public function getSelectQueryString(SelectQuery $selectQuery)
    {
        return $this->selectQueryStringBuilder->getSelectQueryString($selectQuery);

    }

    /**
     * @param InsertQuery $insertQuery
     * @return string
     */
    public function getInsertQueryString(InsertQuery $insertQuery)
    {
        return $this->insertQueryStringBuilder->getInsertQueryString($insertQuery);
    }
}
