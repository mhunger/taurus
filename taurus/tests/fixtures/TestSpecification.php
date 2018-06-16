<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 02/04/17
 * Time: 19:27
 */

namespace taurus\tests\fixtures;


use taurus\framework\db\query\SelectField;
use taurus\framework\db\query\SelectItemFunction;
use taurus\framework\db\query\Specification;

/**
 * Class TestSpecification
 * @package taurus\tests\fixtures
 *
 *
 *
 */
class TestSpecification implements Specification
{

    /**
     * @var string
     * @Having(column="radius", filterType="smallerthanequals", argumentType="number")
     */
    private $radius;

    /**
     * @var string
     */
    private $requestGeoLocation;

    /**
     * @var string
     * @Spec(column="spec_1", filterType="equals", argumentType="string")
     */
    private $spec1;

    /**
     * @var
     * @Spec(column="spec_2", filterType="smallerthanequals", argumentType="number")
     */
    private $spec2;

    /**
     * @var
     * @Spec(column="spec_3", filterType="greaterthanequals", argumentType="string")
     */
    private $spec3;


    /**
     * TestSpecification constructor.
     * @param string $spec1
     * @param $spec2
     * @param $spec3
     * @param $requestGeoLocation
     * @param $radius
     */
    public function __construct($spec1, $spec2, $spec3, $requestGeoLocation, $radius)
    {
        $this->spec1 = $spec1;
        $this->spec2 = $spec2;
        $this->spec3 = $spec3;
        $this->requestGeoLocation = $requestGeoLocation;
        $this->radius = $radius;
    }

    /**
     * @return string
     */
    public function getSpec1(): string
    {
        return $this->spec1;
    }

    /**
     * @return mixed
     */
    public function getSpec2()
    {
        return $this->spec2;
    }

    /**
     * @return mixed
     */
    public function getSpec3()
    {
        return $this->spec3;
    }

    /**
     * Return the table for which this specification is
     *
     * @return string
     */
    public function getTable(): string
    {
        return 'test_table';
    }

    public function getSelect(): ?array
    {
        return [
            new SelectField('test_table', '*'),
            new SelectItemFunction('st_distance_sphere', 'radius', ['geo_location', $this->requestGeoLocation])
        ];
    }

    /**
     * @return string
     */
    public function getRadius(): ?string
    {
        return $this->radius;
    }

    /**
     * @return string
     */
    public function getRequestGeoLocation(): ?string
    {
        return $this->requestGeoLocation;
    }
}
