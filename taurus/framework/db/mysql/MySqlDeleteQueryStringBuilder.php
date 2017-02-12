<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 12/02/17
 * Time: 19:04
 */

namespace taurus\framework\db\mysql;


use taurus\framework\db\query\DeleteQuery;
use taurus\framework\db\query\DeleteQueryStringBuilder;
use taurus\framework\db\query\QueryStringBuilder;

class MySqlDeleteQueryStringBuilder implements DeleteQueryStringBuilder
{
    public function getDeleteQueryString(DeleteQuery $deleteQuery): string
    {
        //@TODO need to implement parsing of query
        return '';
    }
}