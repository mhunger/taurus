<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 27/01/17
 * Time: 21:28
 */

namespace taurus\framework\db\query;


class BooleanExpression {
    private $operand;

    private $operator;

    private $operation;

    /**
     * @param $operand
     * @param $operation
     * @param $operator
     */
    function __construct($operand, $operation = null, $operator = null)
    {
        $this->operand = $operand;
        $this->operator = $operator;
        $this->operation = $operation;
    }

    /**
     * @return mixed
     */
    public function getOperand()
    {
        return $this->operand;
    }

    /**
     * @return mixed
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * @return mixed
     */
    public function getOperation()
    {
        return $this->operation;
    }
}
