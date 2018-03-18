<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 02/04/17
 * Time: 17:28
 */

namespace taurus\framework\db\query\expression;


use taurus\framework\annotation\AnnotationReader;
use taurus\framework\annotation\Spec;
use taurus\framework\db\query\operation\AndOperation;
use taurus\framework\db\query\operation\Equals;
use taurus\framework\db\query\operation\GreaterThan;
use taurus\framework\db\query\operation\GreaterThanEquals;
use taurus\framework\db\query\operation\Like;
use taurus\framework\db\query\operation\Operation;
use taurus\framework\db\query\operation\SmallerThan;
use taurus\framework\db\query\operation\SmallerThanEquals;
use taurus\framework\db\query\Specification;
use taurus\framework\error\SpecificationFilterTypeNotDefine;
use taurus\framework\util\ObjectUtils;

class ExpressionBuilder
{

    /** @var AnnotationReader */
    private $annotationReader;

    /** @var ObjectUtils */
    private $objectUtils;

    /**
     * ExpressionBuilder constructor.
     * @param AnnotationReader $annotationReader
     * @param ObjectUtils $objectUtils
     */
    public function __construct(AnnotationReader $annotationReader, ObjectUtils $objectUtils)
    {
        $this->annotationReader = $annotationReader;
        $this->objectUtils = $objectUtils;
    }

    /**
     * @param Specification $specification
     * @return MultiPartExpression
     */
    public function build(Specification $specification): MultiPartExpression
    {
        $this->annotationReader->getAnnotationsForObject($specification);
        $specs = $this->annotationReader->getAnnotationByName(Spec::ANNOTATION_NAME_SPEC);

        $comparisonExpressions = $this->getComparisonExpressions($specs, $specification);

        return $this->createConditional($comparisonExpressions);

    }

    /**
     * @param $comparisonExpressions
     * @return MultiPartExpression
     */
    private function createConditional($comparisonExpressions): MultiPartExpression
    {
        while(sizeof($comparisonExpressions) > 1) {
            //take two elements from front,
            $expression1 = array_shift($comparisonExpressions);
            $expression2 = array_shift($comparisonExpressions);

            $conditional = new ConditionalExpression(
                $expression1,
                new AndOperation(),
                $expression2
            );

            $comparisonExpressions[] = $conditional;
        }

        return $comparisonExpressions[0];
    }


    /**
     * @param array $specs
     * @param Specification $specification
     * @return array
     * @throws SpecificationFilterTypeNotDefine
     */
    private function getComparisonExpressions(array $specs, Specification $specification): array
    {
        $result = [];
        /** @var Spec $specAnnotation */
        foreach($specs as $specAnnotation) {

            /**
             * only build a condition, when the filter was passed, therefore first check whether the value
             * in the specificaiton is not null. s
             */
            if ($this->objectUtils->getObjectValue(
                    $specification,
                    $specAnnotation->getProperty()
                ) !== null
            ) {

                /**
                 * Here we build the comparison expression for the filter value passed in the request
                 * by getting column from the spec annotation and creating a literal on the other side
                 * with the filter value from the specification object
                 */
                $result[] = new ComparisonExpression(
                    new Field($specAnnotation->getColumn()),
                    $this->getOperation($specAnnotation->getFilterType()),
                    new Literal(
                        $this->objectUtils->getObjectValue(
                            $specification,
                            $specAnnotation->getProperty()
                        ),
                        $specAnnotation->getFilterType(),
                        $specAnnotation->getArgumentType()
                    )
                );
            }
        }

        return $result;
    }

    /**
     * Return the correct operation based on the filter type. It can be equals or like
     *
     * @param string $filterType
     * @return Operation
     * @throws SpecificationFilterTypeNotDefine
     */
    private function getOperation(string $filterType): Operation
    {
        switch ($filterType) {
            case Spec::SPEC_ANNOTATION_FILTER_TYPE_EQUALS:
                return new Equals();
            case Spec::SPEC_ANNOTATION_FILTER_TYPE_LIKE:
                return new Like();
            case Spec::SPEC_ANNOTATION_FILTER_TYPE_SmallerThan:
                return new SmallerThan();
            case Spec::SPEC_ANNOTATION_FILTER_TYPE_GreaterThan:
                return new GreaterThan();
            case Spec::SPEC_ANNOTATION_FILTER_TYPE_GreaterThanEquals:
                return new GreaterThanEquals();
            case Spec::SPEC_ANNOTATION_FILTER_TYPE_SmallerThanEquals:
                return new SmallerThanEquals();
            default:
                throw new SpecificationFilterTypeNotDefine('Could not define the FilterType for a Specification Annotation');
        }
    }
}
