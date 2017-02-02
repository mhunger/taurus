<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 02/02/17
 * Time: 20:26
 */

namespace taurus\framework\db\query\operation;


use taurus\framework\db\query\operation\ComparisonOperation;

class Equals implements ComparisonOperation
{

    private $sign = '=';

    private $name = 'equals';

    public function getOperation()
    {
        return Operation::OPERATION_COMPARISON_EQUALS;
    }
}