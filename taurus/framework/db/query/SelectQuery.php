<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 27/01/17
 * Time: 19:08
 */

namespace taurus\framework\db\query;

    /**
     * Class to model a query with its elements
     *
     * Class Query
     * @package taurus\framework\db\query
     */
/**
 * Class SelectQuery
 * @package taurus\framework\db\query
 */
class SelectQuery
{
    /** @var array */
    private $fields;

    /** @var string */
    private $table;

    /** @var string */
    private $db;

    /** @var array */
    private $groupBy;

    /** @var array */
    private $orderBy;

    /** @var int */
    private $limit;

    /** @var int */
    private $offset;

    /**
     * @param array $fields
     * @return SelectQuery
     */
    public function select(array $fields = null)
    {
        return $this;
    }

    /**
     * @param array $table
     * @param null $db
     * @return $this
     */
    public function from($table, $db = null)
    {
        return $this;
    }

    /**
     * @param $value
     * @return SelectQuery
     */
    public function where($value = null)
    {

    }

    /**
     * @param array $groupBy
     */
    public function groupBy(array $groupBy)
    {
        $this->groupBy = $groupBy;
    }

    /**
     * @param $offset
     * @param $limit
     */
    public function limit($offset, $limit)
    {
        $this->limit = $limit;
        $this->offset = $offset;
    }

    /**
     * @param array $orderBy
     */
    public function orderBy(array $orderBy)
    {
        $this->orderBy = $orderBy;

    }
}
