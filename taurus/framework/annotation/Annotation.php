<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 16/12/16
 * Time: 11:29
 */

namespace taurus\framework\annotation;


class Annotation {

    /** @var string */
    protected $name;

    /** @var array */
    protected $properties;

    /**
     * @param $name
     * @param array $properties
     */
    public function __construct($name, array $properties = null) {
        $this->name = $name;
        if($properties !== null) {
            $this->addProperties($properties);
        } else {
            $this->properties = [];
        }
    }

    public function addProperties(array $properties) {
        foreach($properties as $property) {
            $this->addProperty($property);
        }
    }

    /**
     * Returns the value of the property passed
     *
     * @param $name
     * @return null | mixed
     */
    public function getProperty($name) {
        if(isset($this->properties[$name])) {
            return $this->properties[$name];
        }

        return null;
    }

    /**
     * @param AnnotationProperty $property
     */
    public function addProperty(AnnotationProperty $property)
    {
        $this->properties[$property->getName()] = $property;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    public function getPropertyValue($property) {
        return $this->properties[$property]->getValue();
    }
}