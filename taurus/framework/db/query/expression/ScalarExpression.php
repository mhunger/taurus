<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 02/02/17
 * Time: 20:10
 */

namespace taurus\framework\db\query\expression;


abstract class ScalarExpression implements Expression
{

    /** @var Expression */
    private $value;

    /**
     * @param Expression $value
     */
    function __construct(Expression $value)
    {
        $this->value = $value;
    }

    /**
     * @return Expression
     */
    public function getValue()
    {
        return $this->value;
    }

    abstract public function getType();
}