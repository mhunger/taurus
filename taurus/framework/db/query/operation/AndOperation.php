<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 02/02/17
 * Time: 21:30
 */

namespace taurus\framework\db\query\operation;

class AndOperation implements ConditionalOperation
{

    /**
     * @return string
     */
    public function getOperation(): string
    {
        return Operation::OPERATION_CONDITIONAL_AND;
    }
}