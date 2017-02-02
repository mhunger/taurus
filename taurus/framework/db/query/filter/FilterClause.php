<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 29/01/17
 * Time: 18:02
 */

namespace taurus\framework\db\query\filter;

use taurus\framework\db\query\operations\Operation;

/**
 * This class is used to wrap the filter conditions of a database query. This is strongly relating to where-clause types,
 * but should be capable of expressing the logic of any sql, nosql, key-value store filter expression.
 * The concept is based on the assumption that any filter expression is a chain of matching patterns concatenated
 * by boolean expressions.
 *
 * Class FilterExpression
 * @package taurus\framework\db\query
 */
class FilterClause {

    /** @var FilterExpression */
    private $leftExpression;

    /** @var FilterExpression */
    private $rightExpression;

    /** @var Operation */
    private $operation;

    /** @var FilterClause */
    private $nextExpression;

    /** @var boolean */
    private $precedence;

    /**
     * @return boolean
     */
    public function isPrecedence()
    {
        return $this->precedence;
    }

    /**
     * @return FilterClause
     */
    public function getNextExpression()
    {
        return $this->nextExpression;
    }

    /**
     * @return Operation
     */
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * @return FilterExpression
     */
    public function getRightExpression()
    {
        return $this->rightExpression;
    }

    /**
     * @return FilterExpression
     */
    public function getLeftExpression()
    {
        return $this->leftExpression;
    }
}