<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 27/01/17
 * Time: 19:10
 */

namespace taurus\framework\db\query;

/**
 * Class for the conditions of a where query. It stores a change of field = value and/or field1 = value chain.
 * no precedence markers can be set in a condition. These should be set in between condition objects.
 * Class Condition
 * @package taurus\framework\db\query
 */
class Condition {

    const CONDITION_AND = 'AND';
    const CONDITION_OR = 'OR';
    const CONDITION_EQUALS = '=';
    const CONDITION_LESS = '<';
    const CONDITION_GREATER = '>';
    const CONDITION_BETWEEN = 'between';

    /** @var array */
    private $conditions = [];

    /** @var int */
    private $precondition;

    /**
     * @param null $precondition
     */
    public function __construct($precondition = null) {
        $this->precondition = $precondition;
    }

    /**
     * @param $value
     * @return SelectQuery
     */
    public function value($value) {
        $this->conditions[] = new BooleanExpression($value);
        return $this;
    }

    /**
     * @param $value
     * @return Condition
     */
    public function isEqualTo($value) {
        return $this->addCondition(self::CONDITION_EQUALS, $value);
    }

    /**
     * @param $value
     * @return Condition
     */
    public function isLessThan($value) {
        return $this->addCondition(self::CONDITION_LESS, $value);
    }

    /**
     * @param $value
     * @return Condition
     */
    public function isGreaterThan($value) {
        return $this->addCondition(self::CONDITION_GREATER, $value);
    }

    /**
     * @param $value
     * @return Condition
     */
    public function andWhere($value) {
        return $this->addCondition(self::CONDITION_AND, null, $value);
    }

    /**
     * @param $value
     * @return Condition
     */
    public function orWhere($value) {
        return $this->addCondition(self::CONDITION_OR, $value);
    }

    /**
     * @param $condition
     * @param $value
     * @return Condition
     */
    private function addCondition($condition, $value, $operand = null) {
        $this->conditions[] = new BooleanExpression($operand, $condition, $value);
        return $this;
    }

    /**
     * @return array
     */
    public function getConditions() {
        return $this->conditions;
    }

    /**
     * @return int
     */
    public function getPrecondition()
    {
        return $this->precondition;
    }
}
