<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 02/02/17
 * Time: 21:30
 */

namespace taurus\framework\db\query\operation;


use taurus\framework\db\query\expression\Expression;

class AndOperation implements ConditionalOperation
{

    /**
     * @return int
     */
    public function getOperation()
    {
        return Operation::OPERATION_CONDITIONAL_AND;
    }
}