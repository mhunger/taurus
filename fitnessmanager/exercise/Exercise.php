<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 05/02/17
 * Time: 16:06
 */

namespace fitnessmanager\exercise;

use taurus\framework\db\Entity;

/**
 * Class Exercise
 * @package fitnessmanager\exercise
 * @Entity(table="exercise")
 */
class Exercise implements Entity
{
    /**
     * @var int
     * @Id
     * @Column(name="exercise_id")
     */
    public $id;

    /**
     * @var string
     * @Column(name="name")
     */
    public $name;

    /**
     * @var string
     * @Column(name="difficulty")
     */
    public $difficulty;

    /**
     * @var string
     * @Column(name="variant_name")
     */
    public $variantName;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
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

    /**
     * @return string
     */
    public function getDifficulty()
    {
        return $this->difficulty;
    }

    /**
     * @param $difficulty
     * @return $this
     */
    public function setDifficulty($difficulty)
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    /**
     * @return string
     */
    public function getVariantName()
    {
        return $this->variantName;
    }

    /**
     * @param $variantName
     * @return $this
     */
    public function setVariantName($variantName)
    {
        $this->variantName = $variantName;

        return $this;
    }
}
