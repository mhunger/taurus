<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 29/01/17
 * Time: 19:54
 */

namespace taurus\framework\db\query\expression;


use taurus\framework\db\query\filter\SimpleFilterExpression;
use taurus\framework\db\query\operations\Equal;
use taurus\framework\db\query\operations\Operation;

class ExpressionBuilder {

    /**
     * @param $fieldName
     * @param $value
     * @return SimpleFilterExpression
     */
    public function createEqualExpression($fieldName, $value) {
        if(is_string($value)) {
            $expression = new String($value);
        } else {
            $expression = new Number($value);
        }

        $equalExpression = new SimpleFilterExpression(
            new Field($fieldName),
            $expression,
            new Equal()
        );

        return $equalExpression;
    }
}