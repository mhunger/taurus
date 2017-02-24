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
use taurus\framework\error\GetterDoesNotExistException;

class EntityMetaDataImpl implements EntityMetaDataWrapper
{

    /** @var EntityMetaDataStore */
    private $entityMetaDataStore;

    /** @var AnnotationReader */
    private $reader;
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
     * @param Entity $entity
     * @return mixed
     */
    public function getIdValue(Entity $entity)
    {
        return $this->executeGetterOnEntity(
            $entity,
            $this->getIdField(get_class($entity))
        );
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

        /**
         * @var string $property
         * @var Annotation $columnAnnotation
         */
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
            $values[] = $this->executeGetterOnEntity($entity, $property);
        }

        return $values;
    }

    /**
     * @param Entity $entity
     * @return array
     */
    public function getColumnNameValueMap(Entity $entity): array
    {
        $values = [];
        $columns = $this->entityMetaDataStore
            ->getEntityMetaData(get_class($entity))
            ->getColumns();

        foreach ($columns as $property => $columnAnnotation) {
            $values[$property] = $this->executeGetterOnEntity($entity, $property);
        }

        return $values;
    }

    /**
     * @param Entity $entity
     * @param string $property
     * @return mixed
     * @throws GetterDoesNotExistException
     */
    private function executeGetterOnEntity(Entity $entity, string $property)
    {
        $getterMethodName = 'get' . strtoupper($property);

        if (method_exists($entity, $getterMethodName)) {
            return call_user_func(
                [$entity, $getterMethodName]
            );
        }

        throw new GetterDoesNotExistException('Getter [' . $getterMethodName . '] does not exist in [' . get_class($entity) . ']');
    }
}
