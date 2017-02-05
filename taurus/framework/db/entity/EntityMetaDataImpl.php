<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 04/02/17
 * Time: 17:16
 */

namespace taurus\framework\db\entity;

use taurus\framework\annotation\Annotation;
use taurus\framework\annotation\AnnotationReader;
use taurus\framework\db\Entity;
use taurus\framework\db\entity\EntityMetaDataWrapper;
use taurus\framework\db\entity\EntityMetaData;

class EntityMetaDataImpl implements EntityMetaDataWrapper
{

    /** @var EntityMetaDataStore */
    private $entityMetaDataStore;

    /**
     * @param AnnotationReader $reader
     * @param EntityMetaDataStore $entityMetaDataStore
     */
    function __construct(AnnotationReader $reader = null, EntityMetaDataStore $entityMetaDataStore)
    {
        $this->reader = $reader;
        $this->entityMetaDataStore = $entityMetaDataStore;
    }

    /**
     * @param $class
     * @return mixed
     */
    public function getIdField($class)
    {
        return $this->entityMetaDataStore
            ->getEntityMetaData($class)
            ->getId();
    }

    /**
     * @param $class
     * @return string
     */
    public function getTable($class)
    {
        return $this->entityMetaDataStore
            ->getEntityMetaData($class)
            ->getTable();
    }

    /**
     * @param Entity $entity
     * @return array
     */
    public function getColumns(Entity $entity)
    {
        // TODO: Implement getColumns() method.
        return array();
    }

    /**
     * @param Entity $entity
     * @return array
     */
    public function getColumnValues(Entity $entity)
    {
        return array();
    }
}
