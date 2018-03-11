<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 02/02/17
 * Time: 20:15
 */

namespace taurus\framework\db\query\expression;

use taurus\framework\annotation\Spec;


/**
 * Represents a literal value in an expression e.g. fieldname = 1
 *
 * Class Literal
 * @package taurus\framework\db\query\expression
 */
class Literal extends ScalarExpression
{

    /**
     * @var mixed
     */
    private $value;

    /** @var string */
    private $argumentType;

    /** @var string */
    private $filterType;

    /**
     * @param mixed $value
     * @param string $filterType
     * @param string $argumentType
     */
    public function __construct(
        $value,
        string $filterType = null,
        string $argumentType = null
    ) {
        $this->value = $value;

        if($filterType === null) {
            $this->filterType = Spec::SPEC_ANNOTATION_FILTER_TYPE_EQUALS;
        } else {
            $this->filterType = $filterType;
        }

        if($argumentType === null) {
            if(is_string($value)) {
                $this->argumentType = Spec::SPEC_ANNOTATION_ARGUMENT_TYPE_STRING;
            } else {
                $this->argumentType = Spec::SPEC_ANNOTATION_ARGUMENT_TYPE_NUMBER;
            }
        } else {
            $this->argumentType = $argumentType;
        }
    }

    public function getValue()
    {
        $value = $this->value;

        if($this->getFilterType() == Spec::SPEC_ANNOTATION_FILTER_TYPE_LIKE)
        {
            $value .= '%';
        }

        if($this->getArgumentType() == Spec::SPEC_ANNOTATION_ARGUMENT_TYPE_STRING)
        {
            $value = "'$value'";
        }

        return $value;
    }

    public function getType(): int
    {
        return Expression::EXPRESSION_TYPE_LITERAL;
    }

    /**
     * @return string
     */
    public function getArgumentType(): ?string
    {
        return $this->argumentType;
    }

    /**
     * @return string
     */
    public function getFilterType(): string
    {
        return $this->filterType;
    }
}
