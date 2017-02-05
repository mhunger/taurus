<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 05/02/17
 * Time: 12:46
 */

namespace taurus\framework\db\query;


use taurus\framework\db\query\SelectQuery;

interface SelectQueryStringBuilder
{

    public function getSelectQueryString(SelectQuery $query);
}