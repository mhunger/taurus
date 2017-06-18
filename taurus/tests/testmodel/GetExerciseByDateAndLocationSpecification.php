<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 02/04/17
 * Time: 17:10
 */

namespace taurus\tests\testmodel;


use taurus\framework\db\query\Specification;

class GetExerciseByDateAndLocationSpecification implements Specification
{
    /**
     * @var string
     * @Spec(column="name", type="string")
     */
    private $name;

    /**
     * @var string
     * @Spec(column="difficulty", type="id")
     */
    private $exerciseDifficulty;

    /**
     * GetExerciseByDateAndLocationSpecification constructor.
     * @param string $name
     * @param int $difficulty
     */
    public function __construct($name, $difficulty)
    {
        $this->name = $name;
        $this->exerciseDifficulty = $difficulty;
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        return Exercise::EXERCISE_TABLE_NAME;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getExerciseDifficulty(): string
    {
        return $this->exerciseDifficulty;
    }
}
