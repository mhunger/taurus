<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 18/06/17
 * Time: 13:26
 */

namespace fitnessmanager\config;


use taurus\framework\api\ApiBuilder;
use taurus\framework\Container;
use taurus\framework\routing\AbstractRouteConfig;
use fitnessmanager\exercise\Exercise;
use fitnessmanager\exercise\ExerciseGroup;
use fitnessmanager\exercise\GetExerciseByDateAndLocationSpecification;
use fitnessmanager\exercise\MuscleGroup;
use fitnessmanager\workout\Workout;
use fitnessmanager\workout\WorkoutLocation;


class FitnessManagerRouteconfig extends AbstractRouteConfig
{
    const API_BASE_PATH = 'fitness-api';

    /**
     * FitnessManagerRouteconfig constructor.
     * @param string $base
     * @param ApiBuilder $apiBuilder
     */
    public function __construct($base = '', ApiBuilder $apiBuilder)
    {
        parent::__construct($base, $apiBuilder);

        $this
            ->addRoute('GET', 'item',
                Container::getInstance()->getService(FitnessManagerTestConfig::SERVICE_GET_WORKOUT_BY_ID_CONTROLLER))
            ->addRoute('GET', 'items',
                Container::getInstance()->getService(FitnessManagerTestConfig::SERVICE_GET_WORKOUTS_CONTROLLER))
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
            )->addDefaultRoute(
                $this->apiBuilder->get(ExerciseGroup::class)
            )->addDefaultRoute(
                $this->apiBuilder->post(ExerciseGroup::class)
            )->addDefaultRoute(
                $this->apiBuilder->cget(ExerciseGroup::class)
            )->addDefaultRoute(
                $this->apiBuilder->cget(Workout::class)
            )->addDefaultRoute(
                $this->apiBuilder->get(Workout::class)
            )->addDefaultRoute(
                $this->apiBuilder->post(Workout::class)
            )->addDefaultRoute(
                $this->apiBuilder->cget(MuscleGroup::class)
            )->addDefaultRoute(
                $this->apiBuilder->post(MuscleGroup::class)
            )->addDefaultRoute(
                $this->apiBuilder->get(MuscleGroup::class)
            )->addDefaultRoute(
                $this->apiBuilder->cget(WorkoutLocation::class)
            )->addDefaultRoute(
                $this->apiBuilder->post(WorkoutLocation::class)
            )->addDefaultRoute(
                $this->apiBuilder->get(WorkoutLocation::class)
            );
    }
}
