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
use taurus\framework\db\query\expression\MultiPartExpression;

/**
 * Class SelectQuery
 * @package taurus\framework\db\query
 */
class SelectQuery implements Query
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

    /** @var MultiPartExpression */
    private $where;

    /** @var array */
    private $join = [];

    /**
     * The $fields array has the form [table => field, table => field, ...]
     * @TODO this should be an object in future not an array with specific structure
     *
     * @param array $fields
     * @return SelectQuery
     */
    public function select(array $fields = null): SelectQuery
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * @param string $table
     * @param string|null $db
     * @return SelectQuery
     */
    public function from(string $table, string $db = null): SelectQuery
    {
        $this->table = $table;
        $this->db = $db;

        return $this;
    }

    /**
     * @param string $table
     * @param null $alias
     * @param string $field
     * @param string $referenceField
     * @return SelectQuery
     */
    public function join(string $table, $alias = null, string $field, string $referenceField): SelectQuery
    {
        $this->join[] = new JoinStatement(
            $table,
            $alias,
            $field,
            $referenceField
        );

        return $this;
    }

    /**
     * @param MultiPartExpression $multiPartExpression
     * @return SelectQuery
     */
    public function where(MultiPartExpression $multiPartExpression): SelectQuery
    {
        $this->where = $multiPartExpression;

        return $this;
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
     * @return SelectQuery
     */
    public function limit($offset, $limit): SelectQuery
    {
        $this->limit = $limit;
        $this->offset = $offset;

        return $this;
    }

    /**
     * @param array $orderBy
     * @return SelectQuery
     */
    public function orderBy(array $orderBy): SelectQuery
    {
        $this->orderBy = $orderBy;
        return $this;
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @return string
     */
    public function getDb()
    {
        return $this->db;
    }

    /**
     * @return array
     */
    public function getGroupBy()
    {
        return $this->groupBy;
    }

    /**
     * @return array
     */
    public function getOrderBy()
    {
        return $this->orderBy;
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @return MultiPartExpression
     */
    public function getWhere()
    {
        return $this->where;
    }

    /**
     * @return array
     */
    public function getJoin(): array
    {
        return $this->join;
    }
}
