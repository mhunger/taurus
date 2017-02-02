<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 29/01/17
 * Time: 19:40
 */

namespace taurus\framework\db\query\expression;


class Field implements ExpressionPart{

    private $name;

    private $db;

    private $type;

    function __construct($name, $db = null, $type = null)
    {
        $this->name = $name;
        $this->db = $db;
        $this->type = $type;
    }


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