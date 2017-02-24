<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 24/02/17
 * Time: 21:08
 */

namespace taurus\tests\api;


use fitnessmanager\exercise\Exercise;
use taurus\framework\api\GetAllEntitiesApiController;
use taurus\framework\api\GetAllEntitiesDefaultServiceImpl;
use taurus\framework\config\TaurusContainerConfig;
use taurus\framework\Container;
use taurus\framework\mock\MockRequest;
use taurus\tests\AbstractDatabaseTest;

class GetAllEntitiesApiControllerTest extends AbstractDatabaseTest
{
    /** @var GetAllEntitiesApiController */
    private $controller;

    public function setUp()
    {
        parent::setUp();

        /** @var GetAllEntitiesApiController $controller */
        $controller = Container::getInstance()->getService(TaurusContainerConfig::SERVICE_DEFAULT_GET_ALL_ENTITIES_CONTROLLER);
        /** @var GetAllEntitiesDefaultServiceImpl $service */
        $service = Container::getInstance()->getService(TaurusContainerConfig::SERVICE_DEFAULT_GET_ALL_ENTITIES_SERVICE);
        $service->setEntityClass(Exercise::class);
        $controller->setGetAllEntitiesService($service);
        $this->controller = $controller;
    }

    public function testGetAllEntities()
    {
        $expectedResult = [
            (new Exercise())->setId(3)->setName('Pull-Up')->setDifficulty('hard')->setVariantName('Chinup'),
            (new Exercise())->setId(4)->setName('Push-Ups')->setDifficulty('medium')->setVariantName('Standing')
        ];

        $request = (new MockRequest())->setMethod('GET')->setUrl('test');
        $this->assertEquals(
            $expectedResult,
            $this->controller->handleRequest($request),
            'Default api controller to load all entities does not return correct entities'
        );
    }

    /**
     * @return array
     */
    function getFixtureFiles(): array
    {
        return [
            'exercise.xml'
        ];
    }
}
