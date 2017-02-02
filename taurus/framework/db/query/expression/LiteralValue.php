<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 29/01/17
 * Time: 19:42
 */

namespace taurus\framework\db\query\expression;


abstract class LiteralValue implements Literal {

    /**
     * @var
     */
    private $value;

    /**
     * @param $value
     */
    function __construct($value)
    {
        $this->value = $value;
    }


    /** @return mixed */
    public function getValue()
    {
        return $this->value;
    }


}