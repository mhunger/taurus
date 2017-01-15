<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 18/12/16
 * Time: 22:26
 */

namespace taurus\tests\fixtures;


class DependencyLoadTestClass {

    /**
     * @var TestClass
     */
    public $dependency;

    /**
     * @param Dependency $dependency
     */
    public function __construct(Dependency $dependency) {
        $this->dependency = $dependency;
    }
}