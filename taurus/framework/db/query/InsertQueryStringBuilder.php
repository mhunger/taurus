<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 05/02/17
 * Time: 12:46
 */

namespace taurus\framework\db\query;


interface InsertQueryStringBuilder
{

    public function getInsertQueryString(InsertQuery $insertQuery);
}