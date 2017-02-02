<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 02/02/17
 * Time: 20:16
 */

namespace taurus\framework\db\query\expression;


use taurus\framework\db\query\operation\Operation;

interface MultiPartExpression extends Expression
{


    /**
     * @return Operation
     */
    public function getOperation();

    /**
     * @return Expression
     */
    public function getOperand();
}