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
    /**
     * @return string
     */
    public function getOperation(): string
    {
        return Operation::OPERATION_COMPARISON_EQUALS;
    }
}