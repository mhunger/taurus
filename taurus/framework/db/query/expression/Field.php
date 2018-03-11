<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 02/02/17
 * Time: 20:14
 */

namespace taurus\framework\db\query\expression;


/**
 * Represents a field in a query expression of the type field = something else
 *
 * Class Field
 * @package taurus\framework\db\query\expression
 */
class Field extends ScalarExpression
{

    /**
     * @var string
     */
    private $value;


    /**
     * @param mixed $value
     */
    function __construct(string $value)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }

    /**
     *
     */
    public function getType(): int
    {
        return Expression::EXPRESSION_TYPE_FIELD;
    }
}