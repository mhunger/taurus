<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 05/02/17
 * Time: 22:07
 */

namespace taurus\framework\error;


class MysqlQueryException extends \Exception
{

    /**
     * @param string $sql
     */
    public function __construct($sql)
    {
        $message = 'Could not execute the query: [' . $sql . ']';
        parent::__construct($message);
    }
}
