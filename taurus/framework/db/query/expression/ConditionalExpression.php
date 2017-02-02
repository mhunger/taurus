<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 02/02/17
 * Time: 21:27
 */

namespace taurus\framework\db\query\expression;


use taurus\framework\db\query\operation\Operation;

class ConditionalExpression extends AbstractMultiPartExpression
{

    /**
     * @param Expression $expression
     * @param Operation $operation
     * @param Expression $operand
     */
    public function __construct(Expression $expression = null, Operation $operation = null, Expression $operand = null)
    {
        if ($expression !== null &&
            $operand !== null
            && $operation !== null
        ) {
            parent::__construct($expression, $operation, $operand);
        }
    }

    public function getType()
    {
        return Expression::EXPRESSION_TYPE_CONDITIONAL;
    }
}