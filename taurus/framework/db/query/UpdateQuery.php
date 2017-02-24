<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 12/02/17
 * Time: 22:03
 */

namespace taurus\framework\db\query;


class UpdateQuery implements Query
{
    /**
     * @var
     */
    private $table;

    /**
     * @var array
     */
    private $updates;

    /** @var array */
    private $where = [];

    /**
     * @param string $table
     * @return UpdateQuery
     */
    public function update(string $table): UpdateQuery
    {
        $this->table = $table;

        return $this;
    }

    /**
     * @param array $updates
     * @return UpdateQuery
     */
    public function set(array $updates): UpdateQuery
    {
        $this->updates = $updates;

        return $this;
    }

    /**
     * @param $field
     * @param $value
     * @return UpdateQuery
     */
    public function where($field, $value): UpdateQuery
    {
        $this->where[$field] = $value;

        return $this;
    }

    /**
     * @param $field
     * @param $value
     * @return UpdateQuery
     */
    public function andWhere($field, $value): UpdateQuery
    {
        $this->where[] = [$field => $value];

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
     * @return array
     */
    public function getUpdates(): array
    {
        return $this->updates;
    }

    /**
     * @return array
     */
    public function getWhere(): array
    {
        return $this->where;
    }
}
