<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 15/01/17
 * Time: 16:08
 */

namespace taurus\tests\fixtures;


class LoadDependenciesWithParamsInDependency {

    /** @var LoadDependenciesForLiteralsTestClass */
    protected $loadDependenciesForLiteralsTestClass;

    /**
     * @param LoadDependenciesForLiteralsTestClass $loadDependenciesForLiteralsTestClass
     */
    public function __construct(LoadDependenciesForLiteralsTestClass $loadDependenciesForLiteralsTestClass) {
        $this->loadDependenciesForLiteralsTestClass = $loadDependenciesForLiteralsTestClass;
    }
}