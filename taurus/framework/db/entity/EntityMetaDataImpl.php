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
use taurus\framework\db\entity\EntityMetaDataWrapper;
use taurus\framework\db\entity\EntityMetaData;

class EntityMetaDataImpl implements EntityMetaDataWrapper
{
    const ENTITY_ANNOTATION_ID = 'Id';
    const ENTITY_ANNOTATION_COLUMN = 'Column';
    const ANNOTATION_PROPERTY_COLUMN_NAME = 'name';
    const ENTITY_ANNOTATIONS_ENTITY = 'Entity';
    const ANNOTATION_PROPERTY_ENTITY_TABLE = 'table';

    /**
     * @var AnnotationReader
     */
    private $reader;

    /**
     * @var array
     */
    private $entityMetaDataCache = array();

    /**
     * @param AnnotationReader $reader
     * @internal param ReflectionClass|Entity $entityClass
     */
    function __construct(AnnotationReader $reader = null)
    {
        $this->reader = $reader;
    }

    /**
     * @param $class
     */
    public function getIdField($class)
    {
        return $this->getEntityMetaData($class)->getId();
    }

    /**
     * @param $class
     * @return string
     */
    public function getTable($class)
    {
        return $this->getEntityMetaData($class)->getTable();
    }

    /**
     * @param $class
     * @return mixed
     */
    private function getEntityMetaData($class)
    {
        if (!isset($this->entityMetaDataCache[$class])) {
            $this->createEntityMetaData($class);

        }

        return $this->entityMetaDataCache[$class];
    }

    /**
     * @param $class
     * @return EntityMetaData
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

        $this->cacheEntityMetaData($class, $idFieldName, $table);
    }

    /**
     * @param $class
     * @param $idFieldName
     * @param $tableName
     */
    private function cacheEntityMetaData($class, $idFieldName, $tableName)
    {
        $this->entityMetaDataCache[$class] = new EntityMetaData($idFieldName, $tableName);
    }
}
