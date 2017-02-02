<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 02/02/17
 * Time: 20:15
 */

namespace taurus\framework\db\query\expression;


/**
 * Represents a literal value in an expression e.g. fieldname = 1
 *
 * Class Literal
 * @package taurus\framework\db\query\expression
 */
class Literal extends ScalarExpression
{

    /**
     * @var
     */
    private $value;

    /**
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getType()
    {
        return Expression::EXPRESSION_TYPE_LITERAL;
    }
}