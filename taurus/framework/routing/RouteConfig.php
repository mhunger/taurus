<?php
/**
 * Created by PhpStorm.
 * User: michaelhunger
 * Date: 23/10/16
 * Time: 11:19
 */

namespace taurus\framework\routing;

use fitnessmanager\config\FitnessManagerConfig;
use fitnessmanager\exercise\Exercise;
use fitnessmanager\exercise\ExerciseGroup;
use fitnessmanager\exercise\GetExerciseByDateAndLocationSpecification;
use fitnessmanager\exercise\MuscleGroup;
use fitnessmanager\workout\Workout;
use fitnessmanager\workout\WorkoutLocation;
use taurus\framework\api\ApiBuilder;
use taurus\framework\Container;

use taurus\framework\exception\RouteNotFoundException;
use taurus\framework\http\Controller;

/**
 * Class RouteConfig
 * @package taurus\framework\routing
 */
class RouteConfig {

    const API_BASE_PATH = 'api';
    /**
     * @var string
     */
    private $base;
    /**
     * @var array
     */
    private $routes = [];

    /** @var ApiBuilder */
    private $apiBuilder;

    /**
     * RouteConfig constructor.
     * @param string $base
     * @param ApiBuilder $apiBuilder
     */
    public function __construct($base = '', ApiBuilder $apiBuilder)
    {
        $this->base = $base;
        $this->apiBuilder = $apiBuilder;

        $this
            ->addRoute('GET', 'item',
                Container::getInstance()->getService(FitnessManagerConfig::SERVICE_GET_WORKOUT_BY_ID_CONTROLLER))
            ->addRoute('GET', 'items',
                Container::getInstance()->getService(FitnessManagerConfig::SERVICE_GET_WORKOUTS_CONTROLLER))
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
            );;
    }

    /**
     * @param string $method
     * @param string $path
     * @param $controller
     * @return RouteConfig
     */
    public function addRoute(string $method, string $path, $controller): RouteConfig
    {
        $this->routes[] = new BasicRoute(
            $method,
            $path,
            $controller
        );

        return $this;
    }

    /**
     * @param BasicRoute $basicRoute
     * @return RouteConfig
     */
    public function addDefaultRoute(BasicRoute $basicRoute): RouteConfig
    {
        $this->routes[] = $basicRoute;

        return $this;
    }

    /**
     * @return array
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * @param $method
     * @param $path
     * @return mixed
     * @throws RouteNotFoundException
     */
    public function getRoute($method, $path): Controller
    {
        if($this->base !== null) {
            $path = str_replace("/" . $this->base . "/", "", $path);
        }

        /** @var Route $route */
        foreach ($this->routes as $route) {
            if ($route->getMethod() == $method && $route->getPath() == $path) {
                return $route->getController();
            }
        }

        throw new RouteNotFoundException($method, $path);
    }
}
