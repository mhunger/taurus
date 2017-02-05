<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 29/01/17
 * Time: 20:22
 */

namespace taurus\framework\db\entity;


use taurus\framework\db\Entity;

/**
 * Interface EntityMetaDataWrapper
 * @package taurus\framework\db\entity
 */
interface EntityMetaDataWrapper
{

    /**
     * @param $class
     * @return mixed
     */
    public function getIdField($class);

    /**
     * @param $class
     * @return mixed
     */
    public function getTable($class);

    /**
     * @param $class
     * @return array
     * @internal param Entity $entity
     */
    public function getColumns($class);

    /**
     * @param Entity $entity
     * @return array
     */
    public function getColumnValues(Entity $entity);
}
