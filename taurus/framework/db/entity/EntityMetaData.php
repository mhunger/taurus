<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 04/02/17
 * Time: 18:31
 */

namespace taurus\framework\db\entity;

use taurus\framework\annotation\InputProcessor;


/**
 * Class EntityMetaData
 * @package taurus\framework\db
 */
class EntityMetaData
{

    /**
     * @var string
     */
    private $idDbField;

    /**
     * @var string
     */
    private $table;

    /** @var array */
    private $columns;

    /** @var array */
    private $relationships;

    /** @var string */
    private $idProperty;

    /** @var array */
    private $jsonTypes;

    /** @var array */
    private $inputProcessors;

    /**
     * EntityMetaData constructor.
     * @param $id
     * @param $table
     * @param array $columns
     * @param array|null $relationships
     * @param string $idProperty
     * @param array $jsonTypes
     * @param array $inputProcessors
     */
    function __construct(
        $id,
        $table,
        array $columns,
        array $relationships = null,
        string $idProperty,
        array $jsonTypes,
        array $inputProcessors
    ) {
        ksort($columns);
        $this->columns = $columns;
        $this->idDbField = $id;
        $this->table = $table;
        $this->relationships = $relationships;
        $this->idProperty = $idProperty;
        $this->jsonTypes = $jsonTypes;
        $this->inputProcessors = $inputProcessors;
    }

    /**
     * @return mixed
     */
    public function getIdDbField()
    {
        return $this->idDbField;
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

    /**
     * @return string
     */
    public function getIdProperty(): string
    {
        return $this->idProperty;
    }

    /**
     * @return array
     */
    public function getJsonTypes(): array
    {
        return $this->jsonTypes;
    }

    /**
     * @param string $property
     * @return array|InputProcessor
     */
    public function getInputProcessors(string $property)
    {
        if (isset($this->inputProcessors[$property])) {
            return $this->inputProcessors[$property];
        }
        return null;
    }
}
