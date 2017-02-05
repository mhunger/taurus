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
    private $entityMetaDataStore = array();

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
     * @return mixed
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
        $idProperty = $this->reader->getPropertyForAnnotation(self::ENTITY_ANNOTATION_ID);

        $annotations = $this->reader->getAnnotationsForProperty($idProperty);

        /**
         * @var  $name
         * @var Annotation $annotation
         */
        foreach ($annotations as $name => $annotation) {
            if ($name == self::ENTITY_ANNOTATION_COLUMN) {
                $idFieldName = $annotation->getPropertyValue(self::ANNOTATION_PROPERTY_COLUMN_NAME);
            }
        }

        $classAnnotations = $this->reader->getClassAnnotations();
        foreach ($classAnnotations as $name => $annotation) {
            if ($name == self::ENTITY_ANNOTATIONS_ENTITY) {
                $table = $annotation->getPropertyValue(self::ANNOTATION_PROPERTY_ENTITY_TABLE);
            }
        }

        if ($idFieldName === null || $table === null) {
            throw new EntityMetaDataMissingException();
        }
        $this->cacheEntityMetaData($class, $idFieldName, $table);
    }

    /**
     * @param $class
     * @param $idFieldName
     * @param $tableName
     */
    private function cacheEntityMetaData($class, $idFieldName, $tableName)
    {
        $this->entityMetaDataStore[$class] = new EntityMetaData($idFieldName, $tableName);
    }
}
