<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 02/02/17
 * Time: 20:26
 */

namespace taurus\framework\db\query\operation;


class Equals implements ComparisonOperation
{
    public function getOperation()
    {
        return Operation::OPERATION_COMPARISON_EQUALS;
    }
}