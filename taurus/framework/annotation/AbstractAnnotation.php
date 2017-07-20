<?php

namespace taurus\framework\annotation;


abstract class AbstractAnnotation implements Annotation
{
    /** @var string */
    protected $annotationName;

    /** @var string */
    protected $property;

    /**
     * AbstractAnnotation constructor.
     * @param string $property
     */
    public function __construct(string $property, $annotationName)
    {
        $this->annotationName = $annotationName;
        $this->property = $property;
    }

    /**
     * @return string
     */
    public function getAnnotationName(): string
    {
        return $this->annotationName;
    }

    /**
     * @return string
     */
    public function getProperty(): string
    {
        return $this->property;
    }
}
