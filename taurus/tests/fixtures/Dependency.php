<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 18/12/16
 * Time: 22:27
 */

namespace taurus\tests\fixtures;


class Dependency {

    /** @var DependencyTwo */
    private $dependencyTwo;

    /**
     * @param DependencyTwo $dependencyTwo
     */
    public function __construct(DependencyTwo $dependencyTwo) {
        $this->dependencyTwo = $dependencyTwo;
    }
}