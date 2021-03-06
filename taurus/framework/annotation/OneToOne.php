<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 06/03/17
 * Time: 22:25
 */

namespace taurus\framework\annotation;


class OneToOne extends AbstractAnnotation
{
    const ANNOTATION_NAME_ONETOONE = 'OneToOne';

    /**
     * @var string
     */
    private $entity;

    /**
     * @var string
     */
    private $column;

    /**
     * @var string
     */
    private $referenceTable;

    /**
     * @var string
     */
    private $referenceTableField;

    /**
     * OneToOne constructor.
     * @param string $property
     * @param string $entity
     * @param string $column
     * @param string $reference_table
     * @param string $reference_table_field
     */
    public function __construct(
        string $property,
        string $entity,
        string $column,
        string $reference_table,
        string $reference_table_field
    ) {
        parent::__construct($property, self::ANNOTATION_NAME_ONETOONE);
        $this->entity = $entity;
        $this->column = $column;
        $this->referenceTable = $reference_table;
        $this->referenceTableField = $reference_table_field;
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
    public function getReferenceTableField(): string
    {
        return $this->referenceTableField;
    }
}