<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 05/02/17
 * Time: 11:53
 */

namespace taurus\framework\db\query;


/**
 * Class InsertQuery
 * @package taurus\framework\db\query
 */
class InsertQuery implements Query
{

    /**
     * @var
     */
    private $table;

    /**
     * @var
     */
    private $insertFields;

    /**
     * @var
     */
    private $values;

    /**
     * @var bool
     */
    private $multiValueMode = false;

    /**
     * @param $table
     * @param array $insertFields
     * @return $this
     */
    public function insertInto($table, array $insertFields)
    {
        $this->table = $table;
        $this->insertFields = $insertFields;

        return $this;
    }

    /**
     * @param array $values
     * @return $this
     */
    public function values(array $values)
    {
        if (is_array($this->values)) {
            $this->values[] = $values;
            $this->multiValueMode = true;
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @return mixed
     */
    public function getInsertFields()
    {
        return $this->insertFields;
    }

    /**
     * @return mixed
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * @return boolean
     */
    public function isMultiValueMode()
    {
        return $this->multiValueMode;
    }
}
