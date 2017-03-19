<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 29/01/17
 * Time: 20:22
 */

namespace taurus\framework\db\entity;


use taurus\framework\annotation\AbstractAnnotation;
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

    /**
     * @param Entity $entity
     * @return mixed
     */
    public function getIdValue(Entity $entity);

    /**
     * @param Entity $entity
     * @return array
     */
    public function getColumnNameValueMap(Entity $entity): array;

    /**
     * Return an integer that tells the caller whether the column is a mapped column.
     * where 1 = OneToOne, 2 = OneToMany, 3 = ManyToMany, 0 = no mapped column. This is
     * used to grab related objects or sets in entity builder.
     *
     * @param string $class
     * @return AbstractAnnotation|null
     */
    public function getRelationships(string $class);
}
