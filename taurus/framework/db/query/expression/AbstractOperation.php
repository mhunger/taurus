<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 02/02/17
 * Time: 20:21
 */

namespace taurus\framework\db\query\expression;


use taurus\framework\db\query\operation\Operation;

abstract class AbstractOperation implements Operation
{

    /**
     * @var string
     */
    protected $operation;

    /**
     * @return mixed
     */
    public function getOperation(): string
    {
        return $this->operation;
    }
}