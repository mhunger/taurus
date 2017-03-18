<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 06/03/17
 * Time: 19:52
 */

namespace taurus\framework\annotation;


use taurus\framework\error\AnnotationClassCouldNotBeFound;
use taurus\framework\error\AnnotationCouldNotBeInstantiatedException;

class AnnotationBuilder
{

    const DOC_BLOCK_ANNOATIONS = [
        'var',
        'return',
        'package',
        'param'
    ];

    /**
     * @param $property
     * @param array $properties
     * @return Annotation
     * @throws AnnotationClassCouldNotBeFound
     * @throws AnnotationCouldNotBeInstantiatedException
     */
    public function build($annotationName, $property, array $properties = []): Annotation
    {
        if (in_array($property, self::DOC_BLOCK_ANNOATIONS)) {

        }

        if (class_exists(__NAMESPACE__ . '\\' . $annotationName)) {
            $args = array_merge(
                [$property],
                $properties
            );

            $annotationReflectionClass = new \ReflectionClass(__NAMESPACE__ . '\\' . $annotationName);

            if ($this->checkConstructorArguments($annotationReflectionClass->getConstructor(), $args)) {
                return $annotationReflectionClass->newInstanceArgs($args);
            }

            throw new AnnotationCouldNotBeInstantiatedException($property, $properties);
        }

        throw new AnnotationClassCouldNotBeFound($annotationName);
    }

    /**
     * @param \ReflectionMethod $constructor
     * @param array $args
     * @return bool
     */
    public function checkConstructorArguments(\ReflectionMethod $constructor, array $args): bool
    {
        $mandatoryParameters = 0;
        $parameters = $constructor->getParameters();
        /** @var \ReflectionParameter $parameter */
        foreach ($parameters as $parameter) {
            if (!$parameter->isOptional()) {
                $mandatoryParameters++;
            }
        }

        return $mandatoryParameters <= count($args);
    }
}
