<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 02/04/17
 * Time: 17:10
 */

namespace fitnessmanager\exercise;


use taurus\framework\db\query\Specification;

class GetExerciseByDateAndLocationSpecification implements Specification
{
    /**
     * @var string
     * @Spec(column="date", type="string")
     */
    private $date;

    /**
     * @var int
     * @Spec(column="location_id", type="id")
     */
    private $location;

    /**
     * GetExerciseByDateAndLocationSpecification constructor.
     * @param string $date
     * @param int $location
     */
    public function __construct($date, $location)
    {
        $this->date = $date;
        $this->location = $location;
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        return Exercise::EXERCISE_TABLE_NAME;
    }
}
