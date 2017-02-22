<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 22/02/17
 * Time: 20:07
 */

namespace taurus\tests\api;


use fitnessmanager\exercise\Exercise;
use taurus\framework\api\SaveEntityDefaultServiceImpl;
use taurus\framework\config\TaurusContainerConfig;
use taurus\framework\Container;
use taurus\framework\db\entity\BaseRepository;
use taurus\framework\mock\MockRequest;
use taurus\tests\AbstractDatabaseTest;

class SaveEntityDefaultServiceImplTest extends AbstractDatabaseTest
{
    /** @var SaveEntityDefaultServiceImpl */
    private $service;

    /**
     * @return array
     */
    function getFixtureFiles(): array
    {
        return [
            'exercise.xml'
        ];
    }

    public function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->service = Container::getInstance()->getService(TaurusContainerConfig::SERVICE_DEFAULT_SAVE_ENTITY_SERVICE);
    }

    public function testSaveEntityInPost()
    {
        $mockRequest = (new MockRequest())
            ->setMethod('POST')
            ->setUrl('/exercise')
            ->setRequestVariables([
                'exercise' => [
                    'name' => 'TestExercise',
                    'difficulty' => 'TestDifficulty',
                    'variant_name' => 'TestVariant'
                ]
            ]);

        $this->service->setEntityClass(Exercise::class);
        $this->service->saveEntity($mockRequest);

        $expectedEntity = (new Exercise())->setId(5)
            ->setName('TestExercise')
            ->setDifficulty('TestDifficulty')
            ->setVariantName('TestVariant');

        /** @var BaseRepository $baserepo */
        $baserepo = Container::getInstance()->getService(TaurusContainerConfig::SERVICE_BASE_REPOSITORY);
        $actualEntity = $baserepo->findOne(5, Exercise::class);

        $this->assertEquals(
            $expectedEntity,
            $actualEntity,
            'Could not store exercise entity correctly in SaveentityDefault Service'
        );
    }
}
