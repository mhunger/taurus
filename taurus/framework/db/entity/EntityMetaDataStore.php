<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 05/02/17
 * Time: 12:28
 */

namespace taurus\framework\db\entity;


use taurus\framework\annotation\Annotation;
use taurus\framework\annotation\AnnotationReader;
use taurus\framework\error\EntityMetaDataMissingException;

class EntityMetaDataStore
{
    const ENTITY_ANNOTATION_ID = 'Id';
    const ENTITY_ANNOTATION_COLUMN = 'Column';
    const ANNOTATION_PROPERTY_COLUMN_NAME = 'name';
    const ENTITY_ANNOTATIONS_ENTITY = 'Entity';
    const ANNOTATION_PROPERTY_ENTITY_TABLE = 'table';

    /**
     * @var array
     */
    private $entityMetaDataStore = [];

    /**
     * @var AnnotationReader
     */
    private $reader;

    /**
     * @param $reader
     */
    function __construct(AnnotationReader $reader)
    {
        $this->reader = $reader;
    }

    /**
     * @param $class
     * @return EntityMetaData
     */
    public function getEntityMetaData($class)
    {
        if (!isset($this->entityMetaDataStore[$class])) {
            $this->createEntityMetaData($class);
        }

        return $this->entityMetaDataStore[$class];
    }


    /**
     * @param $class
     * @throws EntityMetaDataMissingException
     */
    private function createEntityMetaData($class)
    {
        $this->reader->getAnnotationsByClassname($class);

        $propertyAnnotations = $this->reader->getPropertyAnnotations();

        $columns = [];

        foreach ($propertyAnnotations as $property => $annotations) {
            if (isset($annotations[self::ENTITY_ANNOTATION_COLUMN])) {
                $columns[$property] = $annotations[self::ENTITY_ANNOTATION_COLUMN];
            }

            if (isset($annotations[self::ENTITY_ANNOTATION_ID])) {
                $idFieldName = $annotations[self::ENTITY_ANNOTATION_COLUMN]->getPropertyValue(self::ANNOTATION_PROPERTY_COLUMN_NAME);
            }
        }

        $classAnnotations = $this->reader->getClassAnnotations();
        /**
         * @var string $name
         * @var Annotation $annotation
         */
        foreach ($classAnnotations as $name => $annotation) {
            if ($name == self::ENTITY_ANNOTATIONS_ENTITY) {
                $table = $annotation->getPropertyValue(self::ANNOTATION_PROPERTY_ENTITY_TABLE);
            }
        }

        if ($idFieldName === null || $table === null) {
            throw new EntityMetaDataMissingException();
        }

        $this->cacheEntityMetaData($class, $idFieldName, $table, $columns);
    }


    /**
     * @param $class
     * @param $idFieldName
     * @param $tableName
     * @param array $columns
     */
    private function cacheEntityMetaData($class, $idFieldName, $tableName, array $columns)
    {
        $this->entityMetaDataStore[$class] = new EntityMetaData($idFieldName, $tableName, $columns);
    }
}
