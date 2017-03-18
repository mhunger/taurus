<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 16/12/16
 * Time: 11:10
 */

namespace taurus\framework\annotation;

use ReflectionClass;

/**
 * Class Reader
 * @package taurus\framework\annotation
 */
class AnnotationReader {

    /** @var null|\ReflectionClass */
    protected $reflectionClass = null;

    /** @var array */
    protected $propertyAnnotations = array();

    /** @var array */
    protected $methodAnnotations = array();

    /** @var array */
    protected $classAnnotations = array();

    /** @var array */
    protected $annotationList = array();

    /** @var AnnotationParser */
    protected $annotationParser;

    /**
     * @param AnnotationParser $annotationParser
     */
    public function __construct(AnnotationParser $annotationParser) {
        $this->annotationParser = $annotationParser;
    }

    /**
     * @param $object
     */
    public function getAnnotationsForObject($object)
    {
        if (is_object($object)) {
            $this->getAnnotationsForClass(
                new ReflectionClass($object)
            );
        } else {
            throw new \InvalidArgumentException("Need an object to parse annotations. Given [" . $object . "]");
        }
    }

    /**
     * @param $className
     */
    public function getAnnotationsByClassname($className)
    {
        $this->getAnnotationsForClass(
            new ReflectionClass($className)
        );
    }

    /**
     * @param ReflectionClass $subject
     */
    public function getAnnotationsForClass(ReflectionClass $subject)
    {
        if (!($subject instanceof ReflectionClass)) {
            throw new \InvalidArgumentException("Need to pass an object in order to work. Passed [" . $subject . "]");
        } else {
            $class = $subject;
        }

        $this->classAnnotations = $this->parseComment($class->getDocComment(), $class->getName());

        foreach ($class->getProperties() as $property) {
            $this->propertyAnnotations[$property->getName()] = $this->parseComment(
                $property->getDocComment(),
                $property->getName()
            );
        }

        foreach($class->getMethods() as $method) {
            $this->methodAnnotations[$method->getName()] = $this->parseComment(
                $method->getDocComment(),
                $method->getName()
            );
        }
    }

    /**
     * @param string $comment
     * @param string $classMember
     * @return array
     */
    private function parseComment(string $comment, string $classMember): array
    {
        return $this->annotationParser->parseDocComment($comment, $classMember);
    }

    /**
     * @return null|\ReflectionClass
     */
    public function getReflectionClass()
    {
        return $this->reflectionClass;
    }

    /**
     * @return array
     */
    public function getPropertyAnnotations()
    {
        return $this->propertyAnnotations;
    }

    /**
     * @return array
     */
    public function getMethodAnnotations()
    {
        return $this->methodAnnotations;
    }

    /**
     * @return array
     */
    public function getClassAnnotations()
    {
        return $this->classAnnotations;
    }

    /**
     * @param $annotationName
     * @return string
     */
    public function getPropertyForAnnotation($annotationName) {
        foreach($this->propertyAnnotations as $property => $annotations) {
            /**
             * @var string $name
             * @var AbstractAnnotation $annotation
             */
            foreach($annotations as $name => $annotation) {
                if($name === $annotationName) {
                    return $property;
                }
            }
        }
    }

    /**
     * @param $propertyName
     * @return mixed
     */
    public function getAnnotationsForProperty($propertyName) {
        if(isset($this->propertyAnnotations[$propertyName])) {
            return $this->propertyAnnotations[$propertyName];
        }
    }
}