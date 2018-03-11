<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 11/03/18
 * Time: 14:52
 */

namespace taurus\framework\db\query\operation;


class Like implements ComparisonOperation
{

    /**
     * @return string
     */
    public function getOperation(): string
    {
        return Operation::OPERATION_COMPARISON_LIKE;
    }
}
