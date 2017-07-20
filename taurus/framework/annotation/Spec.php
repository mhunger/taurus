<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 02/04/17
 * Time: 17:53
 */

namespace taurus\framework\annotation;


class Spec extends AbstractAnnotation
{
    const ANNOTATION_NAME_SPEC = 'Spec';

    /** @var string */
    private $column;

    /** @var string */
    private $type;

    /**
     * Spec constructor.
     * @param string $property
     * @param string $name
     * @param string $type
     */
    public function __construct(string $property, string $name, string $type)
    {
        parent::__construct($property, self::ANNOTATION_NAME_SPEC);
        $this->column = $name;
        $this->type = $type;
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
    public function getType(): string
    {
        return $this->type;
    }
}
