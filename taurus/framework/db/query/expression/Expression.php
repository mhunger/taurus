<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 02/02/17
 * Time: 20:08
 */

namespace taurus\framework\db\query\expression;


interface Expression
{
    const EXPRESSION_TYPE_FIELD = 1;
    const EXPRESSION_TYPE_COMPARISON = 2;
    const EXPRESSION_TYPE_LITERAL = 3;
    const EXPRESSION_TYPE_CONDITIONAL = 4;

    /**
     * @return Expression
     */
    public function getValue();

    /**
     * @return int
     */
    public function getType();
}