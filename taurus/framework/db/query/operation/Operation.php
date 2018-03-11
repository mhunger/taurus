<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 02/02/17
 * Time: 20:20
 */

namespace taurus\framework\db\query\operation;


interface Operation
{

    const OPERATION_COMPARISON_EQUALS = '=';
    const OPERATION_CONDITIONAL_AND = 'AND';
    const OPERATION_COMPARISON_LIKE = 'like';


    /**
     * @return string
     */
    public function getOperation(): string;
}