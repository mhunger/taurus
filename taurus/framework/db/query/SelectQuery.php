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
class SelectQuery
{

    /** @var array */
    private $fields;

    /** @var string */
    private $table;

    /** @var string */
    private $db;

    /**
     * @param array $fields
     * @return SelectQuery
     */
    public function select(array $fields = null)
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * @param array $table
     * @param null $db
     * @return $this
     */
    public function from($table, $db = null)
    {
        $this->table = $table;
        $this->db = $db;

        return $this;
    }

    /**
     * @return array
     */
    public function getSelectedFields()
    {
        return $this->fields;
    }

    /**
     * Return the table selected. If db given concatenate with dot e.g. mydb.table
     *
     * @return string
     */
    public function getSelectedTable()
    {
        return ($this->db !== null ? $this->db . '.' : '') . $this->table;
    }
}
