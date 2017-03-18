<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 06/03/17
 * Time: 20:25
 */

namespace taurus\framework\annotation;


class Entity extends AbstractAnnotation
{
    /** @var string */
    private $table;

    const ENTITY_ANNOTATION_NAME = 'Entity';

    /**
     * Entity constructor.
     * @param string $property
     * @param string $table
     */
    public function __construct(string $property, string $table)
    {
        parent::__construct($property, self::ENTITY_ANNOTATION_NAME);
        $this->table = $table;
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }
}