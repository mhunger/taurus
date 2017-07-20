<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 23/04/17
 * Time: 19:19
 */

namespace taurus\framework\annotation;

class OneToMany extends AbstractAnnotation
{
    const ANNOTATION_NAME_ONETOMANY = 'OneToMany';

    /** @var string */
    private $entity;

    /**
     * @var string Field in one-side of the relationships which contains the value i the foreign key
     */
    private $column;

    /** @var string the table representing the many-side in the relationship */
    private $referenceTable;

    /** @var string the fields in the many-side of the relationships holding the foreign key value */
    private $foreignKeyField;

    /**
     * OneToMany constructor.
     * @param string $property
     * @param string $entity
     * @param string $column
     * @param string $reference_table
     * @param string $foreign_key_field
     */
    public function __construct(
        string $property,
        string $entity,
        string $column,
        string $reference_table,
        string $foreign_key_field
    ) {
        parent::__construct($property, self::ANNOTATION_NAME_ONETOMANY);
        $this->entity = $entity;
        $this->column = $column;
        $this->referenceTable = $reference_table;
        $this->foreignKeyField = $foreign_key_field;
    }

    /**
     * @return string
     */
    public function getEntity(): string
    {
        return $this->entity;
    }

    /**
     * @return string
     */
    public function getColumn(): string
    {
        return $this->column;
    }

    /**
     * @return string
     */
    public function getReferenceTable(): string
    {
        return $this->referenceTable;
    }

    /**
     * @return string
     */
    public function getForeignKeyField(): string
    {
        return $this->foreignKeyField;
    }
}
