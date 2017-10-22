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

            if($input->getMethod() == Request::HTTP_GET) {
                $args = $this->getArgsFromRequestVariables($input->getAllParams(), $constructorArgs);
            } elseif ($input->getMethod() == Request::HTTP_POST) {
                $args = $this->getArgsFromBody($input, $constructorArgs);
            }

            return $reflectionClass->newInstanceArgs($args);
        }
    }

    /**
     * @param array $values
     * @param array $parameters
     * @return array
     * @throws CannotMapRequestToSpecificationParameterException
     */
    private function getArgsFromRequestVariables(array $values, array $parameters): array
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

    /**
     * @param Request $input
     * @param array $parameters
     * @return array
     * @throws CannotMapRequestToSpecificationParameterException
     */
    private function getArgsFromBody(Request $input, array $parameters): array
    {
        $args = [];

        /** @var \ReflectionParameter $parameter */
        foreach ($parameters as $parameter) {
            if ($input->getBodyParamByName($parameter->getName()) !== null) {
                $args[] = $input->getBodyParamByName($parameter->getName());
            } else {
                throw new CannotMapRequestToSpecificationParameterException(
                    $parameter,
                    print_r($input, true)
                );
            }
        }

        return $args;

    }

    /**
     * @param \ReflectionClass $class
     * @return array
     */
    private function extractConstructorParameters(\ReflectionClass $class): array
    {
        $constructor = $class->getConstructor();
        return $constructor->getParameters();
    }
}
