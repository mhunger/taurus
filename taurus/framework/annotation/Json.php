<?php
/**
 * Created by PhpStorm.
 * User: michael_hunger
 * Date: 27/07/17
 * Time: 10:29
 */

namespace taurus\framework\annotation;

/**
 * Class Json
 * @package taurus\framework\annotation
 */
class Json extends AbstractAnnotation
{
    const ANNOTATION_NAME = 'Json';

    /**
     * @var string
     */
    private $type;

    /**
     * Json constructor.
     * @param string $property
     * @param string $type
     * @param string|null $name
     */
    public function __construct($property, string $type, string $name = null)
    {
        parent::__construct($property, self::ANNOTATION_NAME);
        $this->type = $type;
    }
}
