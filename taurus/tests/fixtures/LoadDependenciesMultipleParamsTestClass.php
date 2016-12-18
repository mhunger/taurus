<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 18/12/16
 * Time: 23:12
 */

namespace taurus\tests\fixtures;


class LoadDependenciesMultipleParamsTestClass {
    /** @var Dependency */
    private $dependencyOne;

    /** @var DependencyTwo  */
    private $dependencyTwo;

    /**
     * @param Dependency $dependencyOne
     * @param DependencyTwo $dependencyTwo
     */
    public function __construct(Dependency $dependencyOne, DependencyTwo $dependencyTwo) {
        $this->dependencyOne = $dependencyOne;
        $this->dependencyTwo = $dependencyTwo;
    }
}