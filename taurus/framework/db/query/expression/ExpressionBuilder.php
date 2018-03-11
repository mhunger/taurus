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
use taurus\framework\db\query\operation\Like;
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
            switch ($specAnnotation->getFilterType()) {
                case Spec::SPEC_ANNOTATION_FILTER_TYPE_EQUALS:
                    $operation = new Equals();
                    break;

                case Spec::SPEC_ANNOTATION_FILTER_TYPE_LIKE:
                    $operation = new Like();
                    break;

                default:
                    throw new SpecificationFilterTypeNotDefine('Could not define the FilterType for a Specification Annotation');
            }

            $result[] = new ComparisonExpression(
                new Field($specAnnotation->getColumn()),
                $operation,
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
        return $result;
    }
}
