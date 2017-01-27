<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 27/01/17
 * Time: 19:21
 */

namespace taurus\framework\db\query;


/**
 * Used for objects that build concrete query strings from QAL structures
 *
 * Interface QueryStringBuilder
 * @package taurus\framework\db\query
 */
interface QueryStringBuilder
{

    /**
     * @param SelectQuery $selectQuery
     * @return string
     */
    public function getQueryString(SelectQuery $selectQuery);
}