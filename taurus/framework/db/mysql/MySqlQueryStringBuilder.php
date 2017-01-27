<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 27/01/17
 * Time: 19:23
 */

namespace taurus\framework\db\mysql;


use taurus\framework\db\query\QueryStringBuilder;
use taurus\framework\db\query\SelectQuery;

class MySqlQueryStringBuilder implements QueryStringBuilder
{

    const MYSQL_SYNTAX_ALL_FIELDS = '*';

    /**
     * Return the mysql query string given a select query
     *
     * @param SelectQuery $selectQuery
     * @return string
     */
    public function getQueryString(SelectQuery $selectQuery)
    {
        return 'SELECT ' . $this->getFields($selectQuery->getSelectedFields()) .
        ' FROM ' . $selectQuery->getSelectedTable();
    }

    /**
     * Return the list of fields in mysql syntax
     *
     * @param array $fields
     * @return string
     */
    private function getFields(array $fields = null)
    {
        if ($fields === null) {
            return self::MYSQL_SYNTAX_ALL_FIELDS;
        } else {
            return implode(', ', $fields);
        }
    }
}