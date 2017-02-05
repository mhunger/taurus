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
     * @param Entity $class
     * @return array
     */
    public function getColumns($class)
    {
        $columnAnnotations = $this->entityMetaDataStore
            ->getEntityMetaData($class)
            ->getColumns();

        $columns = [];

        /** @var Annotation $annoation */
        foreach($columnAnnotations as $annoation) {
            $columns[] = $annoation->getPropertyValue(EntityMetaDataStore::ANNOTATION_PROPERTY_COLUMN_NAME);
        }

        return $columns;
    }


    /**
     * Returns a map that has the column names as keys and the respective property names as values
     *
     * @param $class
     * @return array
     */
    public function getColumnMap($class)
    {
        $columnAnnotations = $this->entityMetaDataStore
            ->getEntityMetaData($class)
            ->getColumns();

        $map = [];

        foreach ($columnAnnotations as $property => $columnAnnotation) {
            $columnName = $columnAnnotation->getPropertyValue(EntityMetaDataStore::ANNOTATION_PROPERTY_COLUMN_NAME);
            $map[$columnName] = $property;
        }

        return $map;
    }

    /**
     * @param Entity $entity
     * @return array
     */
    public function getColumnValues(Entity $entity)
    {
        $values = [];
        $columns = $this->entityMetaDataStore
            ->getEntityMetaData(get_class($entity))
            ->getColumns();

        foreach($columns as $property => $columnAnnotation) {
            if(method_exists($entity, $this->getGetterMethodName($property))) {
                $values[] = call_user_func(
                    [
                        $entity,
                        $this->getGetterMethodName($property)
                    ]
                );
            }
        }

        return $values;
    }

    /**
     * @param $property
     * @return string
     */
    private function getGetterMethodName($property) {
        return 'get' . strtoupper($property);
    }
}
