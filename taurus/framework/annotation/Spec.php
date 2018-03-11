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

    const SPEC_ANNOTATION_ARGUMENT_TYPE_STRING = 'string';

    const SPEC_ANNOTATION_ARGUMENT_TYPE_NUMBER = 'number';

    const SPEC_ANNOTATION_ARGUMENT_TYPE_RANGE = 'range';

    const SPEC_ANNOTATION_FILTER_TYPE_EQUALS = 'equals';

    const SPEC_ANNOTATION_FILTER_TYPE_LIKE = 'like';

    /** @var string */
    private $column;

    /** @var string */
    private $filterType;

    /** @var string */
    private $argumentType;

    /**
     * Spec constructor.
     * @param string $property
     * @param string $column
     * @param string $filterType
     * @param string $argumentType
     */
    public function __construct(string $property, string $column, string $filterType, string $argumentType = null)
    {
        parent::__construct($property, self::ANNOTATION_NAME_SPEC);
        $this->column = $column;
        $this->filterType = $filterType;
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
    public function getFilterType(): string
    {
        return $this->filterType;
    }

    /**
     * @return string
     */
    public function getArgumentType(): string
    {
        return $this->argumentType;
    }
}
