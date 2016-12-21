<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 21/12/16
 * Time: 19:07
 */

namespace taurus\tests\fixtures;


class LoadDependenciesForLiteralsTestClass {

    /** @var string */
    private $literal;

    /** @var Dependency */
    private $object;

    /** @var int */
    private $literal2;

    /**
     * @param $literal
     * @param DependencyTwo $object
     * @param $literal2
     */
    public function __construct($literal, DependencyTwo $object, $literal2) {
        $this->literal = $literal;
        $this->object = $object;
        $this->literal2 = $literal2;
    }
}