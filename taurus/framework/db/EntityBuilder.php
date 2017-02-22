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
     * @return Entity
     */
    public function convertOne(array $input, $class)
    {
        $columns = $this->entityMetaDataImpl->getColumnMap($class);
        $reflectionClass = new \ReflectionClass($class);
        $entity = $reflectionClass->newInstance();

        foreach ($input as $column => $value) {
            call_user_func([
                $entity,
                $this->getSetterMethodName($columns[$column]),
            ], $value);
        }

        return $entity;
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
