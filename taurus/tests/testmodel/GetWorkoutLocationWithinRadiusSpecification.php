<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 16/06/18
 * Time: 19:49
 */

namespace taurus\tests\testmodel;


use taurus\framework\db\query\SelectField;
use taurus\framework\db\query\SelectItemFunction;
use taurus\framework\db\query\Specification;

/**
 * Class GetWorkoutLocationWithinRadiusSpecification
 * @package taurus\tests\testmodel
 */
class GetWorkoutLocationWithinRadiusSpecification implements Specification
{

    /**
     * @var string
     * @Spec(column="name", filterType="equals", argumentType="string")
     */
    private $name;

    /**
     * @var string
     */
    private $workoutLocation;

    /**
     * @var int
     * @Having(column="radius", filterType="smallerthan", argumentType="number")
     */
    private $radius;

    /**
     * GetWorkoutLocationWithinRadiusSpecification constructor.
     * @param string $name
     * @param string $workoutLocation
     * @param int $radius
     */
    public function __construct(string $name = null, string $workoutLocation = null, int $radius = null)
    {
        $this->name = $name;
        $this->workoutLocation = $workoutLocation;
        $this->radius = $radius;
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        return WorkoutLocation::TABLE_NAME;
    }

    /**
     * @return array|null
     */
    public function getSelect(): ?array
    {
        return [
            new SelectItemFunction('st_distance_sphere', 'radius', [$this->workoutLocation, 'geo_location']),
            new SelectField('workout_location', 'id', 'id'),
            new SelectField('workout_location', 'name', 'name'),
            new SelectItemFunction('st_astext', 'geo_location', ['geo_location'])
        ];
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getWorkoutLocation(): ?string
    {
        return $this->workoutLocation;
    }

    /**
     * @return int
     */
    public function getRadius(): int
    {
        return $this->radius;
    }
}
