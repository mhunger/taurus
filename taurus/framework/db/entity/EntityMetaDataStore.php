<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 05/02/17
 * Time: 12:28
 */

namespace taurus\framework\db\entity;


use const null;
use taurus\framework\annotation\AbstractAnnotation;
use taurus\framework\annotation\AnnotationReader;
use taurus\framework\annotation\Entity;
use taurus\framework\annotation\Json;
use taurus\framework\error\EntityMetaDataMissingException;

class EntityMetaDataStore
{
    const ENTITY_ANNOTATION_ID = 'Id';
    const ENTITY_ANNOTATION_COLUMN = 'Column';
    const ANNOTATION_PROPERTY_COLUMN_NAME = 'name';
    const ENTITY_ANNOTATIONS_ENTITY = 'Entity';
    const ANNOTATION_PROPERTY_ENTITY_TABLE = 'table';
    const ANNOTATION_ENTITY_REL_ONE_TO_ONE = 'OneToOne';
    const ANNOTATION_ENTITY_REL_ONE_TO_MANY = 'OneToMany';
    const ANNOTATION_ENTITY_REL_MANY_TO_MANY = 'ManyToMany';

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
    public function getEntityMetaData(string $class): EntityMetaData
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
        $jsonTypes = [];

        foreach ($propertyAnnotations as $property => $annotations) {
            if (isset($annotations[self::ENTITY_ANNOTATION_COLUMN])) {
                $columns[$property] = $annotations[self::ENTITY_ANNOTATION_COLUMN];
            }

            if (isset($annotations[self::ENTITY_ANNOTATION_ID])) {
                $idFieldName = $annotations[self::ENTITY_ANNOTATION_COLUMN]->getColumnName();
                $idProperty = $property;
            }

            if (isset($annotations[Json::ANNOTATION_NAME])) {
                $jsonTypes[$property] = $annotations[Json::ANNOTATION_NAME];
            }

        }

        /** get the table from entity annotations */
        $classAnnotations = $this->reader->getClassAnnotations();
        $table = $this->getTableFromAnnotations($classAnnotations);

        $relationships = $this->getRelationshipsFromPropertyAnnotations($propertyAnnotations);

        if ($idFieldName === null || $table === null) {
            throw new EntityMetaDataMissingException();
        }

        $this->cacheEntityMetaData($class, $idFieldName, $table, $columns, $relationships, $idProperty, $jsonTypes);
    }

    /**
     * @param string $class
     * @param string $idFieldName
     * @param string $tableName
     * @param array $columns
     * @param array $relationships
     * @param string $idProperty
     * @param array $jsonTypes
     */
    private function cacheEntityMetaData(
        string $class,
        string $idFieldName,
        string $tableName,
        array $columns,
        array $relationships = [],
        string $idProperty,
        array $jsonTypes = []
    ) {
        $this->entityMetaDataStore[$class] = new EntityMetaData($idFieldName, $tableName, $columns, $relationships, $idProperty, $jsonTypes);
    }

    /**
     * @param array $classAnnotations
     * @return string
     * @throws \Exception
     */
    private function getTableFromAnnotations(array $classAnnotations): string
    {

        /**
         * @var string $name
         * @var AbstractAnnotation $annotation
         */
        foreach ($classAnnotations as $name => $annotation) {
            if ($name == self::ENTITY_ANNOTATIONS_ENTITY) {
                /** @var $annotation Entity */
                return $annotation->getTable();
            }
        }

        throw new \Exception('Could not find table in Entity Annotations');
    }

    /**
     * @param array $propertyAnnotations
     * @return array
     */
    private function getRelationshipsFromPropertyAnnotations(array $propertyAnnotations): array
    {
        $relationships = [];

        /**
         * @var $propertyAnnotation string
         * @var $annotations array
         */
        foreach ($propertyAnnotations as $property => $annotations) {
            if (array_key_exists(self::ANNOTATION_ENTITY_REL_ONE_TO_ONE, $annotations)) {
                $relationships[$property] = $annotations[self::ANNOTATION_ENTITY_REL_ONE_TO_ONE];
            }

            if (array_key_exists(self::ANNOTATION_ENTITY_REL_ONE_TO_MANY, $annotations)) {
                $relationships[$property] = $annotations[self::ANNOTATION_ENTITY_REL_ONE_TO_MANY];
            }

            if (array_key_exists(self::ANNOTATION_ENTITY_REL_MANY_TO_MANY, $annotations)) {
                $relationships[$property] = $annotations[self::ANNOTATION_ENTITY_REL_MANY_TO_MANY];
            }
        }

        return $relationships;
    }

    public function getJsonTypes()
    {

    }
}
