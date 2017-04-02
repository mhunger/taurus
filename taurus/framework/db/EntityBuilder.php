<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 15/01/17
 * Time: 17:53
 */

namespace taurus\framework\db;


use taurus\framework\db\entity\EntityMetaDataImpl;
use taurus\framework\db\entity\EntityMetaDataWrapper;
use taurus\framework\util\ObjectUtils;

class EntityBuilder {

    /** @var EntityMetaDataImpl */
    private $entityMetaDataImpl;

    /** @var ObjectUtils */
    private $objUtils;

    /**
     * @param EntityMetaDataWrapper $entityMetaDataImpl
     * @param ObjectUtils $objectUtils
     */
    function __construct(EntityMetaDataWrapper $entityMetaDataImpl, ObjectUtils $objectUtils)
    {
        $this->objUtils = $objectUtils;
        $this->entityMetaDataImpl = $entityMetaDataImpl;
    }

    /**
     * Takes the input and calls the setter of class.
     *
     * @param array $input
     * @param $class
     * @param array $relationshipData
     * @return Entity
     */
    public function convertOne(array $input, $class, array $relationshipData = []): Entity
    {
        $columns = $this->entityMetaDataImpl->getColumnMap($class);
        $reflectionClass = new \ReflectionClass($class);
        $entity = $reflectionClass->newInstance();

        foreach ($input as $column => $value) {
            if(array_key_exists($column, $relationshipData)) {
                $this->objUtils->setObjectValue($entity, $columns[$column], $relationshipData[$column]);
            } else {
                $this->objUtils->setObjectValue($entity, $columns[$column], $value);
            }
        }

        return $entity;
    }


    /**
     * @param array $input
     * @param $class
     * @return array
     */
    public function convertMany(array $input, $class)
    {
        $result = [];
        foreach ($input as $row) {
            $result[] = $this->convertOne($row, $class);
        }

        return $result;
    }
}
