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
use taurus\framework\db\query\Condition;
use taurus\framework\db\query\BooleanExpression;

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
            ' FROM ' . $selectQuery->getSelectedTable() .
            $this->getFilterCriteria($selectQuery->getConditions()) ;
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

    /**
     * @param array $filter
     * @return string
     */
    private function getFilterCriteria(array $filter = null) {
        if(empty($filter) || $filter === null) {
            return '';
        }

        $where = ' WHERE ';

        /** @var Condition $condition */
        foreach($filter as $condition) {
            $where .= $this->getConditions($condition->getConditions());
        }

        return $where;
    }

    /**
     * Conditions are an array that are a chain of value operator operand operator operand, etc
     * such as id = 1 and date = 2017-01-01
     *
     * @param array $conditions
     * @return string
     */
    private function getConditions(array $conditions) {
        $filter = '';

        /** @var BooleanExpression $expression */
        foreach($conditions as $expression) {
            $operator = $expression->getOperator();
            $operand = $expression->getOperand();
            $op = $expression->getOperation();

            if($operand !== null) {
                $filter .= " $operand ";
            }

            if($op !== null) {
                $filter .= " $op ";
            }

            if($operator !== null) {
                if(is_string($operator)) {
                    $operator = "'$operator'";
                }
                $filter .= " $operator ";
            }
        }
        return $filter;
    }
}