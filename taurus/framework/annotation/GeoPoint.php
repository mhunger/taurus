<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 31/05/18
 * Time: 18:09
 */

namespace taurus\framework\annotation;

use taurus\framework\error\InvalidInputException;
use geoPHP;
use taurus\framework\db\entity\types\GeoPoint as GeoPointType;

class GeoPoint extends AbstractAnnotation implements InputProcessor
{
    const ANNOTATION_NAME_GeoPoint = 'GeoPoint';

    /**
     * GeoPoint constructor.
     * @param string $property
     */
    public function __construct($property)
    {
        parent::__construct($property, self::ANNOTATION_NAME_GeoPoint);
    }

    public function applyOnInput($value, string $property = null)
    {
        preg_match('/POINT\(([0-9.]+) ([0-9.]+)\)/', $value, $matches);
        if(sizeof($matches) == 3) {
            return new GeoPointType($matches[1], $matches[2]);
        }

        throw new InvalidInputException($value);
    }

    /**
     * Return the decoded wkb value back to an object that can be json serialised for the output
     * @param $value
     * @param string $property
     * @return mixed|string
     */
    public function applyOnOutput($value, string $property)
    {
        return $value;
    }
}
