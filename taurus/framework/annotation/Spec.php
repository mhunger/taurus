<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 02/04/17
 * Time: 17:53
 */

namespace taurus\framework\annotation;


use taurus\framework\error\SpecAnnotationInvalidFilterType;

/**
 * Class Spec
 * @package taurus\framework\annotation
 */
class Spec extends AbstractAnnotation
{
    const ANNOTATION_NAME_SPEC = 'Spec';

    const SPEC_ANNOTATION_ARGUMENT_TYPE_STRING = 'string';

    const SPEC_ANNOTATION_ARGUMENT_TYPE_NUMBER = 'number';

    const SPEC_ANNOTATION_ARGUMENT_TYPE_RANGE = 'range';

    const SPEC_ANNOTATION_FILTER_TYPE_EQUALS = 'equals';

    const SPEC_ANNOTATION_FILTER_TYPE_LIKE = 'like';

    const SPEC_ANNOTATION_FILTER_TYPE_SmallerThan = 'smallerthan';

    const SPEC_ANNOTATION_FILTER_TYPE_GreaterThan = 'greaterthan';

    const SPEC_ANNOTATION_FILTER_TYPE_SmallerThanEquals = 'smallerthanequals';

    const SPEC_ANNOTATION_FILTER_TYPE_GreaterThanEquals = 'greaterthanequals';

    /**
     * @var array The valid filter types in Spec annotations.
     */
    private static $filterTypes = [
        Spec::SPEC_ANNOTATION_FILTER_TYPE_GreaterThanEquals,
        Spec::SPEC_ANNOTATION_FILTER_TYPE_GreaterThan,
        Spec::SPEC_ANNOTATION_FILTER_TYPE_SmallerThan,
        Spec::SPEC_ANNOTATION_FILTER_TYPE_SmallerThanEquals,
        Spec::SPEC_ANNOTATION_FILTER_TYPE_LIKE,
        Spec::SPEC_ANNOTATION_FILTER_TYPE_EQUALS
    ];

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

        $this->checkFilterType($filterType);

        parent::__construct($property, self::ANNOTATION_NAME_SPEC);
        $this->column = $column;
        $this->filterType = $filterType;
        $this->argumentType = $argumentType;
    }

    /**
     * @param string $filterType
     * @throws SpecAnnotationInvalidFilterType
     */
    private function checkFilterType(string $filterType): void
    {
        if(!in_array($filterType, self::$filterTypes)) {
            throw new SpecAnnotationInvalidFilterType($filterType);
        }
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
    public function getArgumentType(): ?string
    {
        return $this->argumentType;
    }
}
