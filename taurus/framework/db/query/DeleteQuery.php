<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 12/02/17
 * Time: 19:06
 */

namespace taurus\framework\db\query;

/**
 * Class DeleteQuery
 * @package taurus\framework\db\query
 */
class DeleteQuery implements Query
{

    /** @var string */
    private $table;

    /** @var array */
    private $id;

    /** @var string */
    private $idField;

    /**
     * @param $table
     * @return DeleteQuery
     */
    public function deleteFrom($table): DeleteQuery
    {
        $this->table = $table;

        return $this;
    }

    /**
     * @param string $idField
     * @param array $ids
     * @return DeleteQuery
     */
    public function where(string $idField, array $ids): DeleteQuery
    {
        $this->id = $ids;
        $this->idField = $idField;

        return $this;
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * @return array
     */
    public function getId(): array
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getIdField(): string
    {
        return $this->idField;
    }
}
