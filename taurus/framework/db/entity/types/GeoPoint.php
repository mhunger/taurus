<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 31/05/18
 * Time: 18:21
 */

namespace taurus\framework\db\entity\types;


class GeoPoint
{
    /** @var float */
    private $latitude;

    /** @var float */
    private $longitude;

    /**
     * GeoPoint constructor.
     * @param float $latitude
     * @param float $longitude
     */
    public function __construct($latitude, $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    /**
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     */
    public function setLatitude(float $latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * @param float $longitude
     */
    public function setLongitude(float $longitude)
    {
        $this->longitude = $longitude;
    }

    function __toString()
    {
        return 'Point(' . $this->latitude . ', ' . $this->longitude . ')';
    }
}
