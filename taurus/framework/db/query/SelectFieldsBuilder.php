<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 18/06/18
 * Time: 21:01
 */

namespace taurus\framework\db\query;


use taurus\framework\annotation\GeoPoint;
use taurus\framework\db\entity\EntityMetaDataImpl;

class SelectFieldsBuilder
{

    /** @var EntityMetaDataImpl */
    private $entityMetaDataImpl;

    /**
     * SelectFieldsBuilder constructor.
     * @param EntityMetaDataImpl $entityMetaDataImpl
     */
    public function __construct(EntityMetaDataImpl $entityMetaDataImpl)
    {
        $this->entityMetaDataImpl = $entityMetaDataImpl;
    }


    /**
     * Return the list of fields of the entity
     *
     * @param string $entityClass
     * @return array
     */
    public function build(string $entityClass): array
    {
        $columns = $this->entityMetaDataImpl->getColumnMap($entityClass);

        $fields = [];
        foreach ($columns as $column => $property) {
            $inputProcessor = $this->entityMetaDataImpl->getInputProcessors($entityClass, $property);
            if($inputProcessor instanceof GeoPoint) {
                $fields[] = new SelectItemFunction('st_astext', $column, [$column]);
            } else {
                $fields[] = new SelectField($this->entityMetaDataImpl->getTable($entityClass), $column, $column);
            }
        }

        return $fields;
    }
}
