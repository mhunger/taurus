<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 18/12/16
 * Time: 22:24
 */

namespace taurus\tests;


use taurus\framework\container\TaurusContainerConfig;
use PHPUnit\Framework\TestCase;
use taurus\framework\Container;
use taurus\framework\routing\RouteConfig;
use taurus\tests\fixtures\Dependency;
use taurus\tests\fixtures\DependencyLoadTestClass;
use taurus\tests\fixtures\DependencyTwo;
use taurus\tests\fixtures\LoadDependenciesForLiteralsTestClass;
use taurus\tests\fixtures\LoadDependenciesMultipleParamsTestClass;
use taurus\tests\fixtures\TestContainerConfig;

class ContainerTest extends TestCase{

    public function setUp() {

    }

    public function testLoadDependencies() {
        $container = Container::getInstance();

        $expectedObject = new DependencyLoadTestClass(
            new Dependency(
                new DependencyTwo()
            )
        );

        $serviceToLoad = "taurus\\tests\\fixtures\\DependencyLoadTestClass";
        $obj = $container->getService($serviceToLoad);

        $this->assertEquals($expectedObject, $obj, "Loaded Object does not have all dependencies loaded");
    }

    public function testLoadDependenciesMultipleParameters() {
        $container = Container::getInstance();
        $expectedObject = new LoadDependenciesMultipleParamsTestClass(
            new Dependency(
                new DependencyTwo()
            ),
            new DependencyTwo()
        );


        $this->assertEquals(
            $expectedObject,
            $container->getService("taurus\\tests\\fixtures\\LoadDependenciesMultipleParamsTestClass"),
            "Did not load dependencies with multiple params correctly"
        );
    }

    public function testLoadDependenciesWithLiteralParameters() {
        $expectedObject = new RouteConfig("api");
        $this->assertEquals(
            $expectedObject,
            Container::getInstance()->getService(TaurusContainerConfig::SERVICE_ROUTE_CONFIG),
            "Could not load service with literal argument"
        );
    }

    public function testLoadDependeniesWithLiteralParametersDifferentPositions() {
        $expectedObject = new LoadDependenciesForLiteralsTestClass(
            'literal1',
            new DependencyTwo(),
            100
        );
        $this->assertEquals(
            $expectedObject,
            Container::getInstance()->setContainerConfig(
                new TestContainerConfig()
            )->getService(TestContainerConfig::SERVICE_TEST_LITERALS),
            "Could not load literal parameters when injecting at different positions"
        );
    }
}