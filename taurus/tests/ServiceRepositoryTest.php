<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 12/02/17
 * Time: 15:15
 */

namespace taurus\tests;


use fitnessmanager\config\test\TestContainerConfig;
use taurus\framework\Container;
use taurus\framework\container\ServiceRepository;
use taurus\tests\fixtures\Dependency;
use taurus\tests\fixtures\DependencyTwo;

/**
 * Class ServiceRepositoryTest
 * @package taurus\tests
 */
class ServiceRepositoryTest extends AbstractTaurusTest
{
    /** @var ServiceRepository */
    private $serviceRepository;

    protected function setUp()
    {
        parent::setUp();
        $this->serviceRepository = new ServiceRepository();
    }

    public function testAddServiceToRepository()
    {
        $expectedServiceName = TestContainerConfig::SERVICE_TEST_LITERALS;
        $actualObject = Container::getInstance()->getService($expectedServiceName);

        $expectedObject = $this->serviceRepository->getExistingOrAddAndReturnSingleton($expectedServiceName,
            $actualObject);
        $this->assertEquals(
            $expectedObject,
            $actualObject,
            "Did not add and return service to service repo correct"
        );

    }

    public function testGetServiceFromRepository()
    {
        $expectedObject = new DependencyTwo();
        $serviceName = 'testName';

        $this->serviceRepository->getExistingOrAddAndReturnSingleton($serviceName, $expectedObject);

        $this->assertEquals(
            $expectedObject,
            $this->serviceRepository->getServiceByName($serviceName),
            'Could not retrieve a previously stored service'
        );
    }
}
