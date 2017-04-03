<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 02/04/17
 * Time: 17:16
 */

namespace taurus\framework\db\query;


use taurus\framework\annotation\AnnotationReader;
use taurus\framework\exception\CannotMapRequestToSpecificationParameterException;
use taurus\framework\routing\Request;
use taurus\framework\annotation\Spec;

class SpecificationBuilder
{

    /** @var AnnotationReader */
    private $annotationReader;

    /**
     * SpecificationBuilder constructor.
     * @param AnnotationReader $annotationReader
     */
    public function __construct(AnnotationReader $annotationReader)
    {
        $this->annotationReader = $annotationReader;
    }

    /**
     * @param Request $input
     * @param string $class
     * @return Specification
     */
    public function build(Request $input, string $class): Specification
    {
        if(class_exists($class)) {
            $this->annotationReader->getAnnotationsByClassname($class);
            $specAnnotations = $this->annotationReader->getAnnotationByName(Spec::ANNOTATION_NAME_SPEC);

            $reflectionClass = new \ReflectionClass($class);
            $constructorArgs = $this->extractConstructorParameters($reflectionClass);

            $args = $this->getArgs($input->getAllParams(), $constructorArgs);

            return $reflectionClass->newInstanceArgs($args);
        }
    }

    private function getArgs(array $values, array $parameters): array
    {
        $args = [];

        /** @var \ReflectionParameter $parameter */
        foreach ($parameters as $parameter) {
            if (array_key_exists($parameter->getName(), $values)) {
                $args[] = $values[$parameter->getName()];
            } else {
                throw new CannotMapRequestToSpecificationParameterException($parameter, $values);
            }
        }

        return $args;
    }

    private function extractConstructorParameters(\ReflectionClass $class): array
    {
        $constructor = $class->getConstructor();
        return $constructor->getParameters();
    }
}
