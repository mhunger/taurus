<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 19/03/17
 * Time: 12:52
 */

namespace fitnessmanager\exercise;


use taurus\framework\db\Entity;

/**
 * Class MuscleGroup
 * @package fitnessmanager\exercise
 *
 * @Entity(table="muscle_group")
 */
class MuscleGroup implements Entity
{

    /**
     * @var int
     * @Id
     * @Column(name="id")
     */
    public $id;

    /**
     * @var
     * @Column(name="name")
     */
    public $name;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @param $id
     * @return $this
     */
    public function setId(int $id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
}