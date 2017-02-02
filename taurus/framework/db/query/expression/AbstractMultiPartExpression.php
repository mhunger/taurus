<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 02/02/17
 * Time: 20:18
 */

namespace taurus\framework\db\query\expression;


use taurus\framework\db\query\operation\Operation;

abstract class AbstractMultiPartExpression extends ScalarExpression implements MultiPartExpression
{

    /** @var Operation */
    private $operation;

    /** @var Expression */
    private $operand;

    /**
     * @param Expression $value
     * @param Operation $operation
     * @param Expression $operand
     */
    function __construct(Expression $value, Operation $operation, Expression $operand)
    {
        parent::__construct($value);
        $this->operation = $operation;
        $this->operand = $operand;
    }

    /**
     * @return Operation
     */
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * @return Expression
     */
    public function getOperand()
    {
        return $this->operand;
    }
}