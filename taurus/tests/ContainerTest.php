<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 18/12/16
 * Time: 22:24
 */

namespace taurus\tests;


use taurus\framework\annotation\AnnotationParser;
use taurus\framework\annotation\AnnotationReader;
use taurus\framework\config\TaurusContainerConfig;
use PHPUnit\Framework\TestCase;
use taurus\framework\Container;
use taurus\framework\db\entity\BaseRepository;
use taurus\framework\db\entity\DatabaseManager;
use taurus\framework\db\entity\EntityMetaDataStore;
use taurus\framework\db\EntityBuilder;
use taurus\framework\db\entity\EntityMetaDataImpl;
use taurus\framework\db\mysql\MySqlConnection;
use taurus\framework\db\mysql\MysqlInsertQueryStringBuilder;
use taurus\framework\db\mysql\MySqlQueryStringBuilderImpl;
use taurus\framework\db\mysql\MysqlSelectQueryStringBuilder;
use taurus\framework\db\query\QueryBuilder;
use taurus\framework\routing\RouteConfig;
use taurus\tests\fixtures\Dependency;
use taurus\tests\fixtures\DependencyLoadTestClass;
use taurus\tests\fixtures\DependencyTwo;
use taurus\tests\fixtures\LoadDependenciesForLiteralsTestClass;
use taurus\tests\fixtures\LoadDependenciesMultipleParamsTestClass;
use fitnessmanager\config\test\TestContainerConfig;
use taurus\tests\fixtures\LoadDependenciesWithParamsInDependency;

class ContainerTest extends TestCase{

    /** @var Container */
    private $subject;

    public function setUp() {
        $this->subject = Container::getInstance()
            ->setContainerConfig(
                new TestContainerConfig()
            );
    }

    public function testLoadDependencies() {


        $expectedObject = new DependencyLoadTestClass(
            new Dependency(
                new DependencyTwo()
            )
        );

        $serviceToLoad = "taurus\\tests\\fixtures\\DependencyLoadTestClass";
        $obj = $this->subject->getService($serviceToLoad);

        $this->assertEquals($expectedObject, $obj, "Loaded Object does not have all dependencies loaded");
    }

    public function testLoadDependenciesMultipleParameters() {
        $expectedObject = new LoadDependenciesMultipleParamsTestClass(
            new Dependency(
                new DependencyTwo()
            ),
            new DependencyTwo()
        );


        $this->assertEquals(
            $expectedObject,
            $this->subject->getService("taurus\\tests\\fixtures\\LoadDependenciesMultipleParamsTestClass"),
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
            Container::getInstance()->getService(TestContainerConfig::SERVICE_TEST_LITERALS),
            "Could not load literal parameters when injecting at different positions"
        );
    }

    public function testLoadDependenciesWithLiteralParametersInDependency() {
        $expectedObject = new LoadDependenciesWithParamsInDependency(
            new LoadDependenciesForLiteralsTestClass(
                'literal1',
                new DependencyTwo(),
                100
            )
        );

        $this->assertEquals(
            $expectedObject,
            Container::getInstance()->getService(TestContainerConfig::SERVICE_TEST_LITERALS_IN_DEPENDENCY),
            "Could not load service with literal params in dependency"
        );
    }
}
