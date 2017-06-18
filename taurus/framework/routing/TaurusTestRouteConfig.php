<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 23/10/16
 * Time: 11:19
 */

namespace taurus\framework\routing;

use fitnessmanager\config\FitnessManagerTestConfig;
use taurus\tests\testmodel\Exercise;
use taurus\tests\testmodel\ExerciseGroup;
use taurus\tests\testmodel\GetExerciseByDateAndLocationSpecification;
use taurus\tests\testmodel\MuscleGroup;
use taurus\tests\testmodel\Workout;
use taurus\tests\testmodel\WorkoutLocation;
use taurus\framework\api\ApiBuilder;
use taurus\framework\Container;

use taurus\framework\exception\RouteNotFoundException;
use taurus\framework\http\Controller;

/**
 * Class TaurusTestRouteConfig
 * @package taurus\framework\routing
 */
class TaurusTestRouteConfig extends AbstractRouteConfig
{
    const API_BASE_PATH = 'api';

    /**
     * TaurusTestRouteConfig constructor.
     * @param string $base
     * @param ApiBuilder $apiBuilder
     */
    public function __construct($base = '', ApiBuilder $apiBuilder)
    {
        parent::__construct($base, $apiBuilder);

        $this
            ->addDefaultRoute(
                $this->apiBuilder->get(Exercise::class)
            )->addDefaultRoute(
                $this->apiBuilder->post(Exercise::class)
            )->addDefaultRoute(
                $this->apiBuilder->cget(Exercise::class)
            )->addDefaultRoute(
                $this->apiBuilder->put(Exercise::class)
            )->addDefaultRoute(
                $this->apiBuilder->cgetBySpec(
                    Exercise::class,
                    GetExerciseByDateAndLocationSpecification::class,
                    '/exercisesByDateAndLocation'
                )
            );
    }
}
