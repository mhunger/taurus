<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 27/01/17
 * Time: 19:06
 */

namespace taurus\framework\db\query;


/**
 * Class that will manage building queries on QAL, so language-independent
 *
 * Class QueryBuilder
 * @package taurus\framework\db\query
 */
class QueryBuilder
{

    const QUERY_TYPE_SELECT = 1;
    const QUERY_TYPE_INSERT = 2;

    /** @var SelectQuery|InsertQuery */
    private $query;

    public function query($type)
    {
        switch ($type) {
            case self::QUERY_TYPE_SELECT:
                $this->query = new SelectQuery();
                break;

            case self::QUERY_TYPE_INSERT:
                $this->query = new InsertQuery();
                break;
        }

        return $this->query;
    }
}