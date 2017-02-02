<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 29/01/17
 * Time: 18:15
 */

namespace taurus\framework\db\query\filter;

/**
 * Models a field in a filter clause. A field can have a name and a database name as well as a type.
 *
 * Class Field
 * @package taurus\framework\db\query\filter
 */
class Field {

    private $name;

    private $db;

    private $type;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getDb()
    {
        return $this->db;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }
}