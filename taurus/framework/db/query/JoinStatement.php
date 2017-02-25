<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 25/02/17
 * Time: 20:36
 */

namespace taurus\framework\db\query;


class JoinStatement
{
    /**
     * @var string
     */
    private $table;

    /**
     * @var string
     */
    private $field;

    /**
     * @var string
     */
    private $referenceField;

    /**
     * @var string
     */
    private $tableAlias;

    /**
     * JoinStatement constructor.
     * @param string $table
     * @param string $field
     * @param string $referenceField
     * @param string $tableAlias
     */
    public function __construct(string $table, string $tableAlias = null, string $field, string $referenceField)
    {
        $this->table = $table;
        $this->field = $field;
        $this->referenceField = $referenceField;
        $this->tableAlias = $tableAlias;
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * @return string
     */
    public function getReferenceField(): string
    {
        return $this->referenceField;
    }

    /**
     * @return string
     */
    public function getTableAlias(): string
    {
        return $this->tableAlias;
    }
}
