<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 06/03/17
 * Time: 19:52
 */

namespace taurus\framework\annotation;


use function array_key_exists;
use const null;
use ReflectionClass;
use taurus\framework\error\AnnotationClassCouldNotBeFound;
use taurus\framework\error\AnnotationCouldNotBeInstantiatedException;
use taurus\framework\error\MandatoryAnnotationParameterMissing;

class AnnotationBuilder
{

    const DOC_BLOCK_ANNOATIONS = [
        'var',
        'return',
        'package',
        'param'
    ];

    /**
     * @param $annotationName
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
                [
                    'property' => $property
                ],
                $properties
            );

            $annotationReflectionClass = new \ReflectionClass(__NAMESPACE__ . '\\' . $annotationName);


            return $annotationReflectionClass->newInstanceArgs(
                $this->checkAndOrderArguments(
                    $annotationReflectionClass->getConstructor(),
                    $args,
                    $annotationName
                )
            );
        }

        throw new AnnotationClassCouldNotBeFound($annotationName);
    }

    /**
     * @param \ReflectionMethod $constructor
     * @param array $args
     * @param string $annotation
     * @return array
     * @throws MandatoryAnnotationParameterMissing
     */
    public function checkAndOrderArguments(\ReflectionMethod $constructor, array $args, string $annotation): array
    {
        $orderedArguments = [];

        $parameters = $constructor->getParameters();
        /** @var \ReflectionParameter $parameter */
        foreach ($parameters as $parameter) {
            if (!$parameter->isOptional() && !array_key_exists($parameter->getName(), $args)) {
                throw new MandatoryAnnotationParameterMissing($parameter->getName(), $annotation);
            }

            $orderedArguments[] = isset($args[$parameter->getName()])?$args[$parameter->getName()]:null;
        }

        return $orderedArguments;
    }
}

