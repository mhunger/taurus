<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 16/12/16
 * Time: 11:10
 */

namespace taurus\framework\annotation;

class Reader {

    /** @var null|\ReflectionClass */
    protected $reflectionClass = null;

    /** @var array */
    protected $propertyAnnotations = array();

    /** @var array */
    protected $methodAnnotations = array();

    /** @var array */
    protected $classAnnotations = array();

    /** @var AnnotationParser */
    protected $annotationParser;

    /**
     * @param AnnotationParser $annotationParser
     */
    public function __construct(AnnotationParser $annotationParser) {
        $this->annotationParser = $annotationParser;
    }

    /**
     *
     * Parse the annoations for properties, class and methods and store them interanlly
     *
     * @param \ReflectionClass $class
     */
    public function parseAnnotations(\ReflectionClass $class = null) {
        if($class === null) {
            $class = $this->reflectionClass;
        }

        $this->classAnnotations = $this->parseComment($class->getDocComment());

        foreach ($class->getProperties() as $property) {
            $this->propertyAnnotations[$property->getName()] = $this->parseComment(
                $property->getDocComment()
            );
        }

        foreach($class->getMethods() as $method) {
            $this->methodAnnotations[$method->getName()] = $this->parseComment(
                $method->getDocComment()
            );
        }
    }

    /**
     * Parses comment string and returns the annotation objects
     * @param $comment
     * @return array
     */
    private function parseComment($comment) {
        return $this->annotationParser->parseDocComment($comment);
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
}
