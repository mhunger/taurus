<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 18/03/18
 * Time: 16:26
 */

namespace taurus\framework\db\query\operation;


class SmallerThanEquals implements ComparisonOperation
{
    public function getOperation(): string
    {
        return Operation::OPERATION_COMPARISON_STEQ;
    }
}
