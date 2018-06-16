<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 05/11/17
 * Time: 17:46
 */

namespace taurus\framework\annotation;


class PasswordHash extends AbstractAnnotation implements InputProcessor
{
    const ANNOTATION_NAME_PASSWORD_HASH = 'PasswordHash';

    /** @var string */
    private $algo;

    /** @var int */
    private $cost;

    /**
     * PasswordHash constructor.
     * @param string $property
     * @param string $algo
     * @param int $cost
     */
    public function __construct($property, string $algo, int $cost)
    {
        parent::__construct($property, self::ANNOTATION_NAME_PASSWORD_HASH);
        $this->algo = $algo;
        $this->cost = $cost;
    }

    /**
     * @return string
     */
    public function getAlgo(): string
    {
        return $this->algo;
    }

    /**
     * @return int
     */
    public function getCost(): int
    {
        return $this->cost;
    }

    /**
     * @param string $password
     * @param string $property
     * @return bool|string
     */
    public function applyOnInput($password, string $property = null)
    {
        return password_hash($password, constant($this->algo), ['cost' => $this->cost]);
    }

    /**
     * We don't want to return password hashes, neither passwords in the clear, so set these fields to empty
     *
     * @param $value
     * @param string $property
     * @return string
     */
    public function applyOnOutput($value, string $property)
    {
        return $value;
    }
}
