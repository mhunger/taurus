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
    private $relationships;

    /**
     * EntityMetaData constructor.
     * @param $id
     * @param $table
     * @param array $columns
     * @param array $relationships
     */
    function __construct($id, $table, array $columns, array $relationships = null)
    {
        ksort($columns);
        $this->columns = $columns;
        $this->id = $id;
        $this->table = $table;
        $this->relationships = $relationships;
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

    /**
     * @return array
     */
    public function getRelationships(): array
    {
        return $this->relationships;
    }
}
