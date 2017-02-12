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
use taurus\framework\container\ServiceRepository;
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

class ContainerTest extends AbstractTaurusTest
{

    /** @var Container */
    private $subject;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = Container::getInstance();
    }


    public function testLoadDependencies()
    {
        $expectedObject = new DependencyLoadTestClass(
            new Dependency(
                new DependencyTwo()
            )
        );

        $serviceToLoad = "taurus\\tests\\fixtures\\DependencyLoadTestClass";
        $obj = $this->subject->getService($serviceToLoad);

        $this->assertEquals($expectedObject, $obj, "Loaded Object does not have all dependencies loaded");
    }

    public function testLoadDependenciesMultipleParameters()
    {
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

    public function testLoadDependenciesWithLiteralParameters()
    {
        $expectedObject = new RouteConfig("api");
        $this->assertEquals(
            $expectedObject,
            $this->subject->getService(TaurusContainerConfig::SERVICE_ROUTE_CONFIG),
            "Could not load service with literal argument"
        );
    }

    public function testLoadDependeniesWithLiteralParametersDifferentPositions()
    {
        $expectedObject = new LoadDependenciesForLiteralsTestClass(
            'literal1',
            new DependencyTwo(),
            100
        );
        $this->assertEquals(
            $expectedObject,
            $this->subject->getService(TestContainerConfig::SERVICE_TEST_LITERALS),
            "Could not load literal parameters when injecting at different positions"
        );
    }

    public function testLoadDependenciesWithLiteralParametersInDependency()
    {
        $expectedObject = new LoadDependenciesWithParamsInDependency(
            new LoadDependenciesForLiteralsTestClass(
                'literal1',
                new DependencyTwo(),
                100
            )
        );

        $this->assertEquals(
            $expectedObject,
            $this->subject->getService(TestContainerConfig::SERVICE_TEST_LITERALS_IN_DEPENDENCY),
            "Could not load service with literal params in dependency"
        );
    }

    public function testContainerStoreServicesInServiceRepo()
    {
        $expectedId = 1;
        $expectedInstance = $this->subject->getService(TestContainerConfig::SERVICE_TEST_SINGLETON);
        $this->assertEquals(
            1,
            $expectedInstance->id,
            'Loaded Singleton did not have matching id [' . $expectedInstance->id . ']'
        );

        $reflectionClass = new \ReflectionObject($this->subject);
        /** @var ServiceRepository $serviceRepo */
        $serviceRepoProperty = $reflectionClass->getProperty('serviceRepository');
        $serviceRepoProperty->setAccessible(true);
        $serviceRepo = $serviceRepoProperty->getValue($this->subject);
        $actualObject = $serviceRepo->getServiceByName(TestContainerConfig::SERVICE_TEST_SINGLETON);

        $this->assertTrue(
            ($expectedInstance === $actualObject),
            'Objects did not have the same id'
        );
    }

    public function testContainerStoresAndReturnsSingletonFromRepo()
    {
        $actualObject = $this->subject->getService(TestContainerConfig::SERVICE_TEST_SINGLETON);
        $actualObjectNew = $this->subject->getService(TestContainerConfig::SERVICE_TEST_SINGLETON);

        $this->assertTrue(
            ($actualObject === $actualObjectNew),
            'Objects are not identical even though defined as singleton'
        );
    }

    public function testNonSingletonIsCreatedNewlyEverytime()
    {
        $object = $this->subject->getService(TestContainerConfig::SERVICE_ENVIRONMENT);
        $objectNew = $this->subject->getService(TestContainerConfig::SERVICE_ENVIRONMENT);

        $this->assertFalse(
            ($object === $objectNew),
            'The two objects were identical, even though they are not defined as singleton'
        );
    }
}
