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

class EntityBuilder {

    /** @var EntityMetaDataImpl */
    private $entityMetaDataImpl;

    /**
     * @param EntityMetaDataWrapper $entityMetaDataImpl
     */
    function __construct(EntityMetaDataWrapper $entityMetaDataImpl)
    {
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
                $this->setEntityValue($entity, $columns[$column], $relationshipData[$column]);
            } else {
                $this->setEntityValue($entity, $columns[$column], $value);
            }
        }

        return $entity;
    }

    private function setEntityValue(Entity $entity, string $column, $value)
    {
        $reflectionClass = new \ReflectionClass($entity);

        if($reflectionClass->getMethod($this->getSetterMethodName($column)) !== null) {
            call_user_func([
                $entity,
                $this->getSetterMethodName($column),
            ], $value);
        }
    }

    private function getSetterMethodName($property)
    {
        return 'set' . strtoupper($property);
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
