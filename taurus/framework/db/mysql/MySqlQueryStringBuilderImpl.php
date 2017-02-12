<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 27/01/17
 * Time: 19:23
 */

namespace taurus\framework\db\mysql;


use taurus\framework\db\query\DeleteQuery;
use taurus\framework\db\query\DeleteQueryStringBuilder;
use taurus\framework\db\query\InsertQuery;
use taurus\framework\db\query\InsertQueryStringBuilder;
use taurus\framework\db\query\QueryStringBuilder;
use taurus\framework\db\query\SelectQuery;
use taurus\framework\db\query\SelectQueryStringBuilder;
use taurus\framework\db\query\UpdateQuery;
use taurus\framework\db\query\UpdateQueryStringBuilder;

class MySqlQueryStringBuilderImpl implements QueryStringBuilder
{
    const MYSQL_KEYWORD_WHERE = 'WHERE';
    /** @var SelectQueryStringBuilder */
    private $selectQueryStringBuilder;

    /** @var InsertQueryStringBuilder */
    private $insertQueryStringBuilder;

    /** @var DeleteQueryStringBuilder */
    private $deleteQueryStringBuilder;

    /** @var UpdateQueryStringBuilder */
    private $updateQueryStringBuilder;

    /**
     * MySqlQueryStringBuilderImpl constructor.
     * @param SelectQueryStringBuilder $selectQueryStringBuilder
     * @param InsertQueryStringBuilder $insertQueryStringBuilder
     * @param DeleteQueryStringBuilder $deleteQueryStringBuilder
     * @param UpdateQueryStringBuilder $updateQueryStringBuilder
     */
    function __construct(
        SelectQueryStringBuilder $selectQueryStringBuilder,
        InsertQueryStringBuilder $insertQueryStringBuilder,
        DeleteQueryStringBuilder $deleteQueryStringBuilder,
        UpdateQueryStringBuilder $updateQueryStringBuilder
    ) {
        $this->selectQueryStringBuilder = $selectQueryStringBuilder;
        $this->insertQueryStringBuilder = $insertQueryStringBuilder;
        $this->deleteQueryStringBuilder = $deleteQueryStringBuilder;
        $this->updateQueryStringBuilder = $updateQueryStringBuilder;
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

    public function getDeleteQueryString(DeleteQuery $deleteQuery): string
    {
        return $this->deleteQueryStringBuilder->getDeleteQueryString($deleteQuery);
    }

    public function getUpdateQueryString(UpdateQuery $updateQuery): string
    {
        // TODO: Implement getUpdateQueryString() method.
    }
}
