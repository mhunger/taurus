<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 06/03/17
 * Time: 20:27
 */

namespace taurus\framework\annotation;

class Setter extends AbstractAnnotation
{
    const ANNOTATION_NAME_SETTER = 'Setter';
    /**
     * @var string
     */
    private $attribute;

    /**
     * Setter constructor.
     * @param string $property
     * @param string $attribute
     */
    public function __construct(string $property, string $attribute)
    {
        parent::__construct($property, self::ANNOTATION_NAME_SETTER);
        $this->attribute = $attribute;
    }
}
