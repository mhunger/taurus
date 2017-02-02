<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 29/01/17
 * Time: 19:41
 */

namespace taurus\framework\db\query\expression;


interface Literal extends ExpressionPart{

    /** @return mixed */
    public function getValue();
}