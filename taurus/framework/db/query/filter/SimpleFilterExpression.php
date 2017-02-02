<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 29/01/17
 * Time: 19:48
 */

namespace taurus\framework\db\query\filter;

use taurus\framework\db\query\expression\ExpressionPart;
use taurus\framework\db\query\operations\Operation;

class SimpleFilterExpression implements FilterExpression {

    /** @var ExpressionPart */
    private $leftHand;

    /** @var ExpressionPart */
    private $rightHand;

    /** @var Operation */
    private $operation;

    function __construct(ExpressionPart $leftHand, ExpressionPart $rightHand, Operation $operation)
    {
        $this->leftHand = $leftHand;
        $this->rightHand = $rightHand;
        $this->operation = $operation;
    }
}