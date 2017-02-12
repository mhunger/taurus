<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 12/02/17
 * Time: 15:37
 */

namespace taurus\tests\fixtures;

/**
 * Class TestSingleton
 * @package taurus\tests\fixtures
 */
class TestSingleton
{
    /**
     * @var int
     */
    public $id;


    /**
     * TestSingleton constructor.
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }
}