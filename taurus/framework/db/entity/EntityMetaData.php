<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 04/02/17
 * Time: 18:31
 */

namespace taurus\framework\db\entity;


/**
 * Class EntityMetaData
 * @package taurus\framework\db
 */
class EntityMetaData {

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $table;

    /** @var array */
    private $columns;

    /** @var array */
    private $columnValues;

    /**
     * @param $id
     * @param $table
     * @param array $columns
     */
    function __construct($id, $table, array $columns)
    {
        ksort($columns);
        $this->columns = $columns;
        $this->id = $id;
        $this->table = $table;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @return array
     */
    public function getColumns()
    {
        return $this->columns;
    }
}
