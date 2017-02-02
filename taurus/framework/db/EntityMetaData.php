<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 29/01/17
 * Time: 20:22
 */

namespace taurus\framework\db;


class EntityMetaData {

    /**
     * @var object
     */
    private $entity;

    /**
     * @var Reader
     */
    private $reader;


    /**
     * @param $entity
     * @param $reader
     */
    function __construct($entity = null, $reader = null)
    {
        $this->entity = $entity;
        $this->reader = $reader;
    }

    public function getIdField() {
        return 'id';
    }

    public function getTable() {
        return 'workout';
    }
}