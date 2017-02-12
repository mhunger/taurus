<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 12/02/17
 * Time: 22:07
 */

namespace taurus\framework\db\mysql;


use taurus\framework\db\query\UpdateQuery;
use taurus\framework\db\query\UpdateQueryStringBuilder;

class MySqlUpdateQueryStringBuilder implements UpdateQueryStringBuilder
{

    public function getUpdateQueryString(UpdateQuery $updateQuery): string
    {
        // TODO: Implement getUpdateQueryString() method.
    }
}