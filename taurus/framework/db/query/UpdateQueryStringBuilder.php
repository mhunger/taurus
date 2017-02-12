<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 12/02/17
 * Time: 22:02
 */

namespace taurus\framework\db\query;


interface UpdateQueryStringBuilder
{
    /**
     * @param UpdateQuery $updateQuery
     * @return string
     */
    public function getUpdateQueryString(UpdateQuery $updateQuery): string;

}