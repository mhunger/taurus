<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 12/02/17
 * Time: 19:05
 */

namespace taurus\framework\db\query;

/**
 * Interface DeleteQueryStringBuilder
 * @package taurus\framework\db\query
 */
interface DeleteQueryStringBuilder
{
    /**
     * @param DeleteQuery $deleteQuery
     * @return string
     */
    public function getDeleteQueryString(DeleteQuery $deleteQuery): string;
}