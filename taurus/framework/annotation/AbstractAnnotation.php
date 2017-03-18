<?php

namespace taurus\framework\annotation;


abstract class AbstractAnnotation implements Annotation
{
    /** @var string */
    protected $AnnoationName;

    /** @var string */
    protected $property;

    /**
     * AbstractAnnotation constructor.
     * @param string $property
     */
    public function __construct(string $property, $name)
    {
        $this->AnnoationName = $name;
        $this->property = $property;
    }

    /**
     * @return string
     */
    public function getAnnoationName(): string
    {
        return $this->AnnoationName;
    }

    /**
     * @return string
     */
    public function getProperty(): string
    {
        return $this->property;
    }
}
