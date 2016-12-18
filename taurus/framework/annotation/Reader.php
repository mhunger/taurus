<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 16/12/16
 * Time: 11:10
 */

namespace taurus\framework\annotation;


use SebastianBergmann\ObjectEnumerator\InvalidArgumentException;

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
     * @param $subject
     */
    public function __construct($subject = null) {
        if(!is_object($subject) && !is_null($subject)) {
            throw new InvalidArgumentException("Annotations can only be parsed of objects. Given [" . $subject . ']');
        } elseif (is_object($subject)) {
            $this->reflectionClass = new \ReflectionClass($subject);
        }

        $this->annotationParser = new AnnotationParser();

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
